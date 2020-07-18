<?php

namespace App\Controller\AdminController\AbstrAdmin;

use App\Repository\PostRepository;
use App\Repository\CatergoryUserRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

 abstract class abstractAdminController extends AbstractController
 {


    private $repoCat;
    private $pagi;
    private $repoPost;


    public function __construct(CatergoryUserRepository $repoCat,PaginatorInterface $pagi,PostRepository $repoPost)
    {
        $this->repoCat = $repoCat;
        $this->pagi = $pagi;
        $this->repoPost = $repoPost;

    }



    /**
     * Recupere tout les utilisateurs par catégorie
     * @return response
     */
    public function showAllUserByCat($catego)
    {

        $req = new Request(); 


        // $CategoryTrail = $repo->findOneBy(['name' =>'Trail'])->getUsers();
        // dd($CategoryTrail);


        $users = $this->pagi->paginate(
            $this->repo->findOneBy(['name' =>$catego])->getUsers(), /* query NOT result */
        $req->query->getInt('page', 1), /*page number*/
        5 /*limit per page*/
    );

        return $this->render('admin/usersAdmin/showAllUsers.html.twig',[
            "users"=>$users
        ]);
    }




    /**
     * Fetch post by categories
     * @return response
     */
    public function showAllPostByCat($idCat)
    {
        $req = new Request();
        $posts = $this->pagi->paginate(
            $this->repoCat->findAllWhitPaginatorByCategory(1), /* query NOT result */
            $req->query->getInt('page', 1), /*page number*/
            5 /*limit per page*/
        );
        return $this->render('admin/postAdmin/showAll.html.twig',[
            "posts"=>$posts
        ]);
    }




 }

