<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{

    /**
     * @Route("/user", name="user_gestion")
     */
    public function gestionCompte(UserRepository $repo)
    {
        $userSession = $this->getUser();
        $user = $repo->find($userSession->getId());
        dd($user);
        

        return $this->render('user/index.html.twig',[
            'user' => $user
        ]);
    }
}
