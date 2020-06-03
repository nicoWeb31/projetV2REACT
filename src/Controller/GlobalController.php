<?php

namespace App\Controller;

use DateTime;
use Swift_Mailer;
use Swift_Message;
use App\Entity\User;
use App\Form\UserType;
use App\utils\ApiMeteo;
use App\Form\ContactType;
use App\Form\NewPassType;
use App\Form\RestPasswordType;
use App\Repository\UserRepository;
use Symfony\Component\Mime\Message;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class GlobalController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render('global/home.html.twig');
    }



    // =========================================================================
    // register via token
    // =========================================================================
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
                        'global/email/emailActivation.html.twig', ['token' => $user->getActivationToken()]
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


    // =========================================================================
    // contact avec envoie de mail
    // =========================================================================

    /**
     * @Route("/contact", name="contact")
     */
    public function contact(Request $req, Swift_Mailer $mailer)
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($req);

        if($form->isSubmitted() && $form->isValid()){
            $contact = $form->getData();

            //envoie du mail
            $message = (new \Swift_Message('Nouveau Contact'))
            ->setFrom($contact['email'])
            ->setTo('nico.riot@free.fr')  //a remplacer par le mail de patrick
            ->setBody(
                $this->renderView(
                    'global/email/contact.html.twig',compact('contact')
                ),
                'text/html'
                )
            ;

            //envoie du message
            $mailer->send($message);
            $this->addFlash('messages','le message a été envoyer avec succées');
            return $this->redirectToRoute('contact');
        }

        return $this->render('global/contact.html.twig',[
            'contactForm' =>$form->createView()
        ]);
    }

    // =========================================================================
    // reset mot de pass oublié
    // =========================================================================

    /**
     * @Route("/reset-pass", name="reset_password")
     */
    public function resetPass(Request $req, UserRepository $repoUser, Swift_Mailer $mailer, TokenGeneratorInterface $tokenGenerator,EntityManagerInterface $man)
    {
        //create form
        $form =$this->createForm(RestPasswordType::class);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
            //recup donner
                $data = $form->getData();

                //recherche si un user a cet email
                $user =$repoUser->findOneBy(['mail' => $data['mail']]);

                //si user n'hexiste pas
                if(!$user){
                    $this->addFlash('danger', 'ce mail n\'hexiste pas');
                    $this->redirectToRoute('login');
                }

            //generation du token    
            $token = $tokenGenerator->generateToken();   
            try{
                $user->setResetToken($token);
                $man->persist($user);
                $man->flush();

            }catch(\Exception $e){
                $this->addFlash('warining','Une eurreru est survenue : ' .$e->getMessage());
                return $this->redirectToRoute('login');
            }

        // on genere l'url de reinitialisation de mot de passe
            $url = $this->generateUrl('reset_password_token',['token' => $token ],UrlGeneratorInterface::ABSOLUTE_URL);

            //on envoie le message
            $message = (new Swift_Message('Mot de passe oublié'))
            ->setFrom('nico.riot@free.fr')   //a remplacer
            ->setTo($user->getMail())
            ->setBody(

                $this->renderView(
                    'global/email/demandeNewPassword.html.twig', ['url' => $url]
                ),
                'text/html'

                // "<p>Une demande de réinitialisation de mot de passe a été effecctuée pour le site VTT veuillez cliquer sur le lien suivant : " .$url ."</p>",
                // 'text/html'
                );




            //on envoie
            $mailer->send($message);
            //on crée le message flash
            $this->addFlash('message','un e-mail de réinitialisation de mot de passe a été envoyé');
            return $this->redirectToRoute('login');
        }

        //on envoie vers la page de demande de l'e-mail
        return $this->render('global/passReset.html.twig' ,[
            'resetForm'=> $form->createView()
        ]);
    }


    /**
     * @Route("/reset-password/{token}", name="reset_password_token")
     */
    public function resetPassword($token, Request $req, UserPasswordEncoderInterface $encode,UserRepository $repo, EntityManagerInterface $man)
    {
        
        
        $form = $this->createForm(NewPassType::class);
        $form->handleRequest($req);


        //on recherche avec le token
        $user = $repo->findOneBy(['resetToken' => $token]);
        //si pas de user avec token :
        if(!$user)
        {
            $this->addFlash('danger', 'Token iconnu');
            return $this->redirectToRoute('login');
        }

        if($form->isSubmitted() && $form->isValid()){
            //recup donner
            $data = $form->getData();
            //dd($req->request->get('new_pass')['password']);
            $user->setResetToken(null);
            $user->setPassword($encode->encodePassword($user,$req->request->get('new_pass')['password']));
            $man->persist($user);
            $man->flush();

            $this->addFlash('message','mot de passe modifier avec succes');
            return $this->redirectToRoute('login');
        }else{
            return $this->render('global/ChangPassAfterReset.html.twig',[
                'token'=>$token,
                'form'=>$form->createView()
            ]);
        }
    }



}
