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
     * @Route("/post/{id}", name="post")
     */
    public function showOnePost(Post $post,Request $req, EntityManagerInterface $man)
    {
        $comment = new Comment();   
        $user = $this->getUser(); //recuperation du user
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($req);


        if($form->isSubmitted() && $form->isValid()){

            $comment->setCreatedAd(new DateTime())
                    ->setPost($post)
                    ->setUser($user);

            $man->persist($comment);
            $man->flush();
            $this->addFlash("success","Commentaire ajouter avec succés");

            return $this->redirectToRoute('post',['id' => $post->getId()]);
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

        //id du post pour la redirection
        $idPost = $comment->getPost()->getId();
        //dd($idPost);

        $form = $this->createForm(CommentType::class,$comment);
        $form->handleRequest($req);


        if( $userRole[0] == "ROLE_ADMIN" || $userid == $comment->getUser()->getId()){

            if($form->isSubmitted() && $form->isValid()){
    
    
                $man->persist($comment);
                $man->flush();
                return $this->redirectToRoute('post',['id' => $idPost]);
                exit();
    
            }
        }else{
            return $this->redirectToRoute('post',['id' => $idPost]);
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
        $idPost = $comment->getPost()->getId();

        if( $userRole[0] == "ROLE_ADMIN" || $userid == $comment->getUser()->getId()){

            //test du token arg 1 sup+com id arg 2 dans la req recu du token
            if($this->isCsrfTokenValid("sup".$comment->getId(), $req->get("_token"))){

                $man->remove($comment);
                $man->flush();
                return $this->redirectToRoute('post',['id' => $idPost]);


            }

        }else{
            return $this->redirectToRoute('post',['id' => $idPost]);
        }
    }

}

    
        
