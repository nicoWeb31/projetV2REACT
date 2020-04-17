<?php

namespace App\Controller;

use DateTime;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mime\Message;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class GlobalController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        $user = $this->getUser(); //recuperation du user;
        return $this->render('global/home.html.twig',[
            "user" => $user
        ]);
    }

    /**
     * @Route("/register", name="register")
     */
    public function regiseter(Request $req,EntityManagerInterface $man,UserPasswordEncoderInterface $encode,\Swift_Mailer $mailer)
    {
        $user = new User();
        $form = $this->createForm(UserType::class,$user);
        $form->handleRequest($req);
        
        if($form->isSubmitted() && $form->isValid()){
            $passEncode = $encode->encodePassword($user,$user->getPassword());
            $user->setPassword($passEncode);

            //on genere le token d'activation
            $user->setActivationToken(md5(uniqid()));


            $user->setUpdatedAt(new DateTime('now'));
            $user->setRoles("ROLE_USER");
            $man->persist($user);
            $man->flush();


             // do anything else you need here, like send an email
            // On crée le message
            $message = (new \Swift_Message('Nouveau contact'))
                // On attribue l'expéditeur
                ->setFrom('votre@adresse.fr')
                // On attribue le destinataire
                ->setTo($user->getMail())
                // On crée le texte avec la vue
                ->setBody(
                    $this->renderView(
                        'global/emailActivation.html.twig', ['token' => $user->getActivationToken()]
                    ),
                    'text/html'
                )
            ;
            $mailer->send($message);




            $this->addFlash("success","Compte crée avec succes");
            return $this->redirectToRoute('login');
        }
        return $this->render('global/register.html.twig',[

            "form"=> $form->createView()

        ]);

    }

    /**
     * @Route("/activation/{token}", name ="activation")
     */
    public function activation($token,UserRepository $userRepo,EntityManagerInterface $man)
    {
        //verif si un user possede le token
        $user = $userRepo->findOneBy(['activationToken' => $token]);


        //si aucun user n'a ce token
        if(!$user)
        {
            //eureur 404
            throw $this->createNotFoundException('cet utilisateur n\'existe pas');
        }

        //suppression du token
        $user->setActivationToken(null);
        $man->persist($user);
        $man->flush();

        //message flash
        $this->addFlash('message',"Votre compte est bien activés");
        //redirect
        return $this->redirectToRoute('home');

    }

    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $utils)
    {
        return $this->render('global/login.html.twig',[
            "lastUserName" => $utils->getLastUsername(),
            "error" => $utils->getLastAuthenticationError()
        ]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {
    
    }
}
