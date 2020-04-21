<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\PostRepository;
use App\Repository\CategoryRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class CategoryController extends AbstractController
{

    /**
     * @Route("/category/Trail", name="Trail")
     */
    public function trail(CategoryRepository $repCat, PostRepository $repPost)
    {
        
        $cat  =$repCat->findByNameCat('Trail');// mes post par categorie  
        $postLastSeven = $repPost->findLastSeven();  //liste des derniers post
        return $this->render('category/trail.html.twig',[
            'cat'=>$cat,
            'lastPost'=>$postLastSeven
        ]);
    }

    /**
     * @Route("/category/Trek", name="Trek")
     */
    public function trek(CategoryRepository $repCat,PostRepository $repPost)
    {

        
        $cat  =$repCat->findByNameCat('Trek');// mes post par categorie  
        $postLastSeven = $repPost->findLastSeven();  //liste des derniers post

        return $this->render('category/trek.html.twig',[
            'cat'=>$cat,
            'lastPost'=>$postLastSeven

        ]);
    }

    /**
     * @Route("/category/Vtt", name="Vtt")
     */
    public function vtt(CategoryRepository $rep,PostRepository $repPost)
    {

        $cat  =$rep->findByNameCat('Vtt');
        $postLastSeven = $repPost->findLastSeven();  //liste des derniers post

        return $this->render('category/vtt.html.twig',[
            'cat'=>$cat,
            'lastPost'=>$postLastSeven

        ]);
    }

    /**
     * @Route("/category/Actu", name="Actu")
     */
    public function actu(CategoryRepository $rep,PostRepository $repPost)
    {

        $cat  =$rep->findByNameCat('Actualités');

        $postLastSeven = $repPost->findLastSeven();  //liste des derniers post

        return $this->render('category/actu.html.twig',[
            'cat'=>$cat,
            'lastPost'=>$postLastSeven

        ]);
    }

}
