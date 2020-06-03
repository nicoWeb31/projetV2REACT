<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Comment;
use App\Form\CommentType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class PostsController extends AbstractController
{
    /**
     * @Route("/post/{slug}", name="post")
     */
    public function showOnePost(Post $post,Request $req, EntityManagerInterface $man)
    {
        $comment = new Comment();
        if($this->getUser()){
            
            $user = $this->getUser(); //recuperation du user
            // dd($user);
        }   


        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($req);


        
        if($form->isSubmitted() && $form->isValid()){

            if($user->getActivationToken() == null){


                $comment->setCreatedAd(new DateTime())
                        ->setPost($post)
                        ->setUser($user);
    
                $man->persist($comment);
                $man->flush();
                $this->addFlash("ok","Commentaire ajouté avec succès");
    
                return $this->redirectToRoute('post',['slug' => $post->getSlug()]);

            }else{
                
                $this->addFlash("pasOk","Valider votre adresse mail pour pouvoir commenter un post, merci !");
                return $this->redirectToRoute('post',['slug' => $post->getSlug()]);

            }

            

        }

        return $this->render('posts/showOnePost.html.twig',[
            'post'=>$post,
            'form'=> $form->createView()

        ]);
    }

    /**
     * @Route("/post/comment/{id}", name="comment_edit",methods ="GET|POST")
     */
    public function ModifComment(Comment $comment,Request $req,EntityManagerInterface $man)
    {

        //id user  et role du user connect pour le test de modification 
        $userid = $this->getUser()->getId(); //recuperation du user
        $userRole = $this->getUser()->getRoles();
        //dd($userRole);

        //slug du post pour la redirection
        $slug = $comment->getPost()->getSlug();
        //dd($idPost);

        $form = $this->createForm(CommentType::class,$comment);
        $form->handleRequest($req);


        if( $userRole[0] == "ROLE_ADMIN" || $userid == $comment->getUser()->getId()){
                

                if($form->isSubmitted() && $form->isValid()){
        
        
                    $man->persist($comment);
                    $man->flush();
                    $this->addFlash("ok","Commentaire modifié avec succès");
                    return $this->redirectToRoute('post',['slug' => $slug]);
                    exit();
        
                }
        }else{
            return $this->redirectToRoute('post',['slug' => $slug]);
        }




        return $this->render('user/modifComment.html.twig',[
            'comment' => $comment,
            'form'=> $form->createView()
        ]);
    }  
    
    
    /**
     * @Route("/post/comment/{id}", name="comment_sup",methods="sup")
     */
    public function suprComment(Comment $comment,EntityManagerInterface $man,Request $req)
    {
        //id user  et role du user connect pour le test de modification 
        $userid = $this->getUser()->getId(); //recuperation du user
        $userRole = $this->getUser()->getRoles();


        //id du post pour la redirection
        $slug = $comment->getPost()->getSlug();

        if( $userRole[0] == "ROLE_ADMIN" || $userid == $comment->getUser()->getId()){

            //test du token arg 1 sup+com id arg 2 dans la req recu du token
            if($this->isCsrfTokenValid("sup".$comment->getId(), $req->get("_token"))){

                $man->remove($comment);
                $man->flush();
                $this->addFlash('ok', "Commentaire supprimé avec succès");
                return $this->redirectToRoute('post',['slug' => $slug]);


            }

        }else{
            return $this->redirectToRoute('post',['slug' => $slug]);
        }
    }

}

    
        
