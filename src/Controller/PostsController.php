<?php

namespace App\Controller;

use App\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PostsController extends AbstractController
{
    /**
     * @Route("/post/{id}", name="post")
     */
    public function showOnePost(Post $post)
    {

        return $this->render('posts/showOnePost.html.twig',[
            'post'=>$post
        ]);
    }
}
