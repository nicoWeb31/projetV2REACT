<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{

    /**
     * @Route("/category/Trail", name="Trail")
     */
    public function trail(CategoryRepository $repCat, PostRepository $repPost)
    {
        $cat = $repCat->findBy(['name'=>'Trail']);   // mes post par categorie
        $postLastSeven = $repPost->findLastSeven();  //liste des derniers post
        return $this->render('category/trail.html.twig',[
            'cat'=>$cat,
            'lastPost'=>$postLastSeven
        ]);
    }

    /**
     * @Route("/category/Trek", name="Trek")
     */
    public function trek(CategoryRepository $rep,PostRepository $repPost)
    {
        $cat = $rep->findBy(['name'=>'Trek']);
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
        $cat = $rep->findBy(['name'=>'Vtt']);
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
        $cat = $rep->findBy(['name'=>'Actualités']);
        $postLastSeven = $repPost->findLastSeven();  //liste des derniers post

        return $this->render('category/actu.html.twig',[
            'cat'=>$cat,
            'lastPost'=>$postLastSeven

        ]);
    }

}
