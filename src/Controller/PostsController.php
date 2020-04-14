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
}
