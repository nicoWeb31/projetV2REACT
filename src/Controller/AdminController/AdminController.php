<?php

namespace App\Controller\AdminController;

use DateTime;
use App\Entity\Post;
use App\Entity\User;
use App\Entity\Photo;
use App\Form\UserType;
use App\Form\PhotoType;
use App\Entity\LastNews;
use App\Form\LastNewsType;
use App\Form\PostFormType;
use App\Form\EditUserAdminType;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use App\Repository\PhotoRepository;
use App\Repository\LastNewsRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CatergoryUserRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\User as UserUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Controller\AdminController\AbstrAdmin\abstractAdminController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

    /**
     * @Route("/admin")
     */
class AdminController extends abstractAdminController
{


    // =========================================================================
    // Post admin
    // =========================================================================

    /**
     * @Route("/post", name="admin.post")
     */
    public function showAllPost(PostRepository $repo,PaginatorInterface $pagi, Request $req)
    {
        $posts = $pagi->paginate(
            $repo->findAllWhitPaginator(), /* query NOT result */
            $req->query->getInt('page', 1), /*page number*/
            5 /*limit per page*/
        );
        return $this->render('admin/postAdmin/showAll.html.twig',[
            "posts"=>$posts
        ]);
    }




    /**
     * filter by category
     * @Route("/post-trail", name="admin_post_trail")
     * @return response
     */
    public function showAllPostCatTrail()
    {
        return $this->showAllPostByCat(2);
    }


    /**
     * filter by category
     * @Route("/post-trek", name="admin_post_trek")
     * @return response
     */
    public function showAllPostCatTreck()
    {
        return $this->showAllPostByCat(3);
    }

    /**
     * filter by category
     * @Route("/post-VTT", name="admin_post_vtt")
     * 
     * @return response
     */
    public function showAllPostCatVTT()
    {
        return $this->showAllPostByCat(4);
    }

    /**
     * filter by category
     * @Route("/post-actu", name="admin_post_actu")
     * 
     * @return response
     */
    public function showAllPostCatActu()
    {
        return $this->showAllPostByCat(5);
    }




    /**
     * @Route("/post/create", name="admin.post.create")
     * @Route("/post/modifier/{id}", name="admin.post.modifier",methods ="GET|POST")
     * 
     */
    public function creatMod(Post $post = null,EntityManagerInterface $man,Request $req)
    {
        if(!$post){
            $post = new Post();
        }
        //recup du fromualaire
        $form = $this->createForm(PostFormType::class,$post);

        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
            $modif = $post->getId() !== null;
            $man->persist($post);
            $man->flush();
            $this->addFlash("success",($modif) ? "Modification effectuée avec succès" : "Ajouté avec succès");
            return $this->redirectToRoute("admin.post");
        }


        return $this->render('admin/postAdmin/creaMod.html.twig',[
            "post"=>$post,
            "form"=>$form->createView(),
            "modif"=> $post->getId() !== null   //test pour mon h1

        ]);
    }

    /**
     * @Route("/post/suppr/{id}", name="admin.post.suppr",methods="sup")
     */
    public function suppr(Post $post, Request $req, EntityManagerInterface $man)
    {
        if($this->isCsrfTokenValid("sup".$post->getId(), $req->get("_token"))){
            $man->remove($post);
            $man->flush();
            $this->addFlash('success', "Post supprimé avec succès");
            return $this->redirectToRoute('admin.post');
        }
    }

    // =========================================================================
    // photos administration
    // =========================================================================

    /**
     * @Route("/photo", name="admin.photo")
     */
    public function showAllPhoto(PhotoRepository $repo,PaginatorInterface $pagi, Request $req)
    {
        $photos = $pagi->paginate(
            $repo->findAllWhitPaginator(), /* query NOT result */
            $req->query->getInt('page', 1), /*page number*/
            6 /*limit per page*/
        );
        return $this->render('admin/photoAdmin/showAllPhoto.html.twig',[
            "photos"=>$photos
        ]);
    }


    /**
     * @Route("/photo/create", name="admin.photo.create")
     * @Route("/photo/modifier/{id}", name="admin.photo.modifier",methods ="GET|POST")
     */
    public function ModCreatPhoto(Photo $photo = null,EntityManagerInterface $man, Request $req)
    {
        if(!$photo){
            $photo = new Photo();
        }

        $form = $this->createForm(PhotoType::class,$photo);
        $form->handleRequest($req);
        
        if($form->isSubmitted() && $form->isValid()){
            $modif = $photo->getId() !== null;
            $photo->setUpdated_at(new DateTime('now'));
            $man->persist($photo);
            $man->flush();
            $this->addFlash("success",($modif) ? "Modification effectuée avec succès" : "Ajoutée avec succès");
            return $this->redirectToRoute('admin.photo');
        }
        return $this->render('admin/photoAdmin/ModCreatPhoto.html.twig',[
            "photo"=>$photo,
            "form"=> $form->createView(),
            "modif"=> $photo->getId() !== null
        ]);

    }

    /**
     * @Route("/photo/suppr/{id}", name="admin.photo.suppr",methods="sup")
     */
    public function supprPhoto(Photo $photo, Request $req, EntityManagerInterface $man)
    {
        if($this->isCsrfTokenValid("sup".$photo->getId(), $req->get("_token"))){
            $man->remove($photo);
            $man->flush();
            $this->addFlash('success', "Photo supprimée avec succès");
            return $this->redirectToRoute('admin.photo');
        }
    }



    // =========================================================================
    // Users adminstraion
    // =========================================================================
    
    /**
     * @Route("/users", name="admin.users")
     */
    public function showAllUser(UserRepository $repo, PaginatorInterface $pagi, Request $req)
    {

        $users = $pagi->paginate(
        $repo->findAllWithPaginator(), /* query NOT result */
        $req->query->getInt('page', 1), /*page number*/
        5 /*limit per page*/
    );
        return $this->render('admin/usersAdmin/showAllUsers.html.twig',[
            "users"=>$users
        ]);
    }



    /**
     * recu user by name
     * @Route("/users-name", name="admin_users_by_name")
     */
    public function showAllUserByName(UserRepository $repo, PaginatorInterface $pagi, Request $req)
    {

        //je recupere l'input pour recup le user, en get avec request
        $userFiled = $req->query->get('user');

        
        $users = $pagi->paginate(
        $repo->findAllWithPaginatorByName($userFiled), /* query NOT result */
        $req->query->getInt('page', 1), /*page number*/
        5 /*limit per page*/
    );
        return $this->render('admin/usersAdmin/showAllUsers.html.twig',[
            "users"=>$users
        ]);
    }


    /**
      *function Abstract class
     * recu user by Category Trail
     * @Route("/users-trail", name="admin_users_trail")
     */
    public function showAllTrail()
    {
        return $this->showAllUserByCat('Trail');
    }

     /**
      * function Abstract class
     * recu user by Category Trail
     * @Route("/users-vtt", name="admin_users_vtt")
     */
    public function showAllVTT()
    {
        return $this->showAllUserByCat('VTT');
    }

     /**
      * function Abstract class
     * recu user by Category Trail
     * @Route("/users-trek", name="admin_users_trek")
     */
    public function showAllTrek()
    {
        return $this->showAllUserByCat('Trek');
    }




    /**
     * @Route("/user/create", name="admin.user.create")
     * @Route("/user/modifier/{id}", name="admin.user.modifier",methods ="GET|POST")
     */
    public function ModCreatUser(User $user = null,EntityManagerInterface $man, Request $req,UserPasswordEncoderInterface $encode)
    {
        if(!$user){
            $user = new User();
        }

        $form = $this->createForm(EditUserAdminType::class,$user);
        $form->handleRequest($req);
        
        if($form->isSubmitted() && $form->isValid()){

            $modif = $user->getId() !== null;
            $user->setUpdatedAt(new DateTime('now'));
            $man->persist($user);
            $man->flush();
            $this->addFlash("success",($modif) ? "Modification effectuée avec succès" : "Ajouté avec succès");
            return $this->redirectToRoute('admin.users');
        }
        return $this->render('admin/usersAdmin/ModCreatUsers.html.twig',[
            "user"=>$user,
            "form"=> $form->createView(),
            "modif"=> $user->getId() !== null
        ]);

    }

    /**
     * @Route("/user/suppr/{id}", name="admin.user.suppr",methods="sup")
     */
    public function supprUser(User $user, Request $req, EntityManagerInterface $man)
    {
        if($this->isCsrfTokenValid("sup".$user->getId(), $req->get("_token"))){
            $man->remove($user);
            $man->flush();
            $this->addFlash('success', "Utilisateur supprimé avec succès");
            return $this->redirectToRoute('admin.users');
        }
    }

      // =========================================================================
    // lastNews Admin
    // =========================================================================

    /**
     * @Route("/lastNews", name="admin.lastNews")
     */
    public function showAllNews(LastNewsRepository $repo)
    {

        $lastNews = $repo->findAll();

        return $this->render('admin/lastNews/showAllNews.html.twig',[
            "lastNews" => $lastNews
        ]);
    }

     /**
     * @Route("/lastNews/suppr/{id}", name="admin.lastNews.suppr",methods="sup")
     */
    public function supprLastNews(LastNews $new, Request $req, EntityManagerInterface $man)
    {
        if($this->isCsrfTokenValid("sup".$new->getId(), $req->get("_token"))){
            $man->remove($new);
            $man->flush();
            $this->addFlash('success', "News supprimé avec succès");
            return $this->redirectToRoute('admin.lastNews');
        }
    }

    /**
     * @Route("/lastNews/create", name="admin.lastNews.create")
     * @Route("/lastNews/modifier/{id}", name="admin.lastNews.modifier",methods ="GET|POST")
     */
    public function ModCreatLastNews(LastNews $new = null,EntityManagerInterface $man, Request $req)
    {
        if(!$new){
            $new = new LastNews();
        }

        $form = $this->createForm(LastNewsType::class,$new);
        $form->handleRequest($req);
        
        if($form->isSubmitted() && $form->isValid()){

            $modif = $new->getId() !== null;
            $man->persist($new);
            $man->flush();
            $this->addFlash("success",($modif) ? "Modification effectuée avec succès" : "Ajouté avec succès");
            return $this->redirectToRoute('admin.lastNews');
        }
        return $this->render('admin/lastNews/ModCreatlastNews.html.twig',[
            "user"=>$new,
            "form"=> $form->createView(),
            "modif"=> $new->getId() !== null
        ]);

    }


}
