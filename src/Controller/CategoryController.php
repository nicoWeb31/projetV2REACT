<?php

namespace App\Controller;

use Exception;
use App\utils\ApiMeteo;
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
    

    private $meteoData;

    public function __construct(ApiMeteo $api)
    {
        $this->meteoData = $api;
    }


    /**
     * @Route("/category/Trail", name="Trail")
     */
    public function trail(CategoryRepository $repCat, PostRepository $repPost,Request $req)
    {
        
        $cat  =$repCat->findByNameCat('Trail');// mes post par categorie  
        $postLastSeven = $repPost->findLastSeven();  //liste des derniers post


         //je recupere ma ville en get avec request
        $ville = $req->query->get('ville');
        //use my methode getMeteo 
        $data = $this->meteoData->getMeteo($ville);

        return $this->render('category/trail.html.twig',[
            'cat'=>$cat,
            'lastPost'=>$postLastSeven,
            'meteo'=>$data[0],
            'ville'=>$ville,
            'err'=>$data[1]
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
        //use my methode getMeteo 
        $data = $this->meteoData->getMeteo($ville);

        return $this->render('category/trek.html.twig',[
            'cat'=>$cat,
            'lastPost'=>$postLastSeven,
            'meteo'=>$data[0],
            'ville'=>$ville,
            'err' => $data[1]


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
        //use my methode getMeteo 
        $data = $this->meteoData->getMeteo($ville);

        return $this->render('category/vtt.html.twig',[
            'cat'=>$cat,
            'lastPost'=>$postLastSeven,
            'meteo'=>$data[0],
            'ville'=>$ville,
            'err'=>$data[1]

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
        
        //use my methode getMeteo 
        $data = $this->meteoData->getMeteo($ville);

        return $this->render('category/actu.html.twig',[
            'cat'=>$cat,
            'lastPost'=>$postLastSeven,
            'meteo'=>$data[0],
            'ville'=>$ville,
            'err'=>$data[1]

        ]);
    }




 






}
