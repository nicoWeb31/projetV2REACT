<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\PostRepository;
use App\Repository\CategoryRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class CategoryController extends AbstractController
{
    


    public function __construct()
    {
        
    }


    /**
     * @Route("/category/Trail", name="Trail")
     */
    public function trail(CategoryRepository $repCat, PostRepository $repPost,SerializerInterface $seria,Request $req)
    {
        
        $cat  =$repCat->findByNameCat('Trail');// mes post par categorie  
        $postLastSeven = $repPost->findLastSeven();  //liste des derniers post


         //je recupere ma ville en get avec request
        $ville = $req->query->get('ville');
        if(!$ville){
        $ville ="montespan";
        }

    $meteo = file_get_contents("https://www.prevision-meteo.ch/services/json/".$ville);
    $meteo = $seria->decode($meteo,'json');


        return $this->render('category/trail.html.twig',[
            'cat'=>$cat,
            'lastPost'=>$postLastSeven,
            'meteo'=>$meteo,
            'ville'=>$ville
        ]);
    }

    /**
     * @Route("/category/Trek", name="Trek")
     */
    public function trek(CategoryRepository $repCat,PostRepository $repPost,SerializerInterface $seria, Request $req)
    {

        
        $cat  =$repCat->findByNameCat('Trek');// mes post par categorie  
        $postLastSeven = $repPost->findLastSeven();  //liste des derniers post


         //je recupere ma ville en get avec request
    $ville = $req->query->get('ville');
    if(!$ville){
        $ville ="montespan";
    }
    $meteo = file_get_contents("https://www.prevision-meteo.ch/services/json/".$ville);
    $meteo = $seria->decode($meteo,'json');


        return $this->render('category/trek.html.twig',[
            'cat'=>$cat,
            'lastPost'=>$postLastSeven,
            'meteo'=>$meteo,
            'ville'=>$ville

        ]);
    }

    /**
     * @Route("/category/Vtt", name="Vtt")
     */
    public function vtt(CategoryRepository $rep,PostRepository $repPost,SerializerInterface $seria, Request $req)
    {

        $cat  =$rep->findByNameCat('Vtt');
        $postLastSeven = $repPost->findLastSeven();  //liste des derniers post


         //je recupere ma ville en get avec request
    $ville = $req->query->get('ville');
    if(!$ville){
        $ville ="montespan";
    }
    $meteo = file_get_contents("https://www.prevision-meteo.ch/services/json/".$ville);
    $meteo = $seria->decode($meteo,'json');

        return $this->render('category/vtt.html.twig',[
            'cat'=>$cat,
            'lastPost'=>$postLastSeven,
            'meteo'=>$meteo,
            'ville'=>$ville

        ]);
    }





    // =========================================================================
    // Actualité avec apelle api meteo
    // =========================================================================
    /**
     * @Route("/category/Actu", name="Actu")
     */
    public function actu(CategoryRepository $rep,PostRepository $repPost,SerializerInterface $seria, Request $req)
    {

        $cat  =$rep->findByNameCat('Actualités');
        $postLastSeven = $repPost->findLastSeven();  //liste des derniers post


    //je recupere ma ville en get avec request
    $ville = $req->query->get('ville');
    if(!$ville){
        $ville ="montespan";
    }
    $meteo = file_get_contents("https://www.prevision-meteo.ch/services/json/".$ville);
    $meteo = $seria->decode($meteo,'json');



        return $this->render('category/actu.html.twig',[
            'cat'=>$cat,
            'lastPost'=>$postLastSeven,
            'meteo'=>$meteo,
            'ville'=>$ville

        ]);
    }




    /**
     * fragment entrainement plus api
     * @Route("/_Fragment", name="meteo")
     * 
     */
    public function meteo()
    {
        return $this->render('partial/section/listeEntrainement.html.twig');
    }






}
