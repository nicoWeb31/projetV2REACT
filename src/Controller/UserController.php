<?php

namespace App\Controller;

use DateTime;
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

        return $this->render('user/index.html.twig',[
            "user" => $user,

        ]);
    }


    /**
     * @Route("/user-modifier", name="user_gestion")
     */
    public function gestionCompte(UserRepository $repo , Request $req ,EntityManagerInterface $man)
    {
        $userSession = $this->getUser();
        $user = $repo->find($userSession->getId());

        $form = $this->createForm(UserModInfoType::class,$user);

        $form->handleRequest($req);

        if($form->isSubmitted() && $form->isValid()){
            $user->setUpdatedAt(new DateTime('now'));
            $man->persist($user);
            $man->flush();

            $this->addFlash("ok","Compte modifier avec succès");

            return $this->redirectToRoute('user');
        }


        return $this->render('user/mofiUser.html.twig',[
            "user" => $user,
            "form"=>$form->createView()
        ]);
    }

}
