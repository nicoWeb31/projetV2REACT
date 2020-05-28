<?php

namespace App\Controller\AdminController\AbstrAdmin;

use App\Repository\CatergoryUserRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

 abstract class abstractAdminController extends AbstractController
 {


    private $repo;
    private $pagi;



    public function __construct(CatergoryUserRepository $repo,PaginatorInterface $pagi)
    {
        $this->repo = $repo;
        $this->pagi = $pagi;

    }


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




 }

