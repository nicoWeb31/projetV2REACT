<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserModInfoType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{

    /**
     * @Route("/user", name="user")
     */
    public function Compte(UserRepository $repo)
    {
        $userSession = $this->getUser();
        $user = $repo->find($userSession->getId());

        $form = $this->createForm(UserModInfoType::class);


        return $this->render('user/index.html.twig',[
            "user" => $user,
            "form"=>$form->createView()
        ]);
    }


    /**
     * @Route("/user-modifier", name="user_gestion")
     */
    public function gestionCompte(UserRepository $repo)
    {
        $userSession = $this->getUser();
        $user = $repo->find($userSession->getId());

        $form = $this->createForm(UserModInfoType::class,$user);


        return $this->render('user/mofiUser.html.twig',[
            "user" => $user,
            "form"=>$form->createView()
        ]);
    }

}
