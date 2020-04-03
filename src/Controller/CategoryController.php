<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{

    /**
     * @Route("/category/Trail", name="Trail")
     */
    public function trail(CategoryRepository $rep)
    {
        $cat = $rep->findBy(array('name'=>'Trail'));
        return $this->render('category/trail.html.twig',[
            'cat'=>$cat
        ]);
    }

    /**
     * @Route("/category/Trek", name="Trek")
     */
    public function trek(CategoryRepository $rep)
    {
        $cat = $rep->findBy(array('name'=>'Trek'));
        return $this->render('category/trek.html.twig',[
            'cat'=>$cat
        ]);
    }

    /**
     * @Route("/category/Vtt", name="Vtt")
     */
    public function vtt(CategoryRepository $rep)
    {
        $cat = $rep->findBy(array('name'=>'Vtt'));
        return $this->render('category/vtt.html.twig',[
            'cat'=>$cat
        ]);
    }

    /**
     * @Route("/category/Actu", name="Actu")
     */
    public function actu(CategoryRepository $rep)
    {
        $cat = $rep->findBy(array('name'=>'Actualités'));
        return $this->render('category/actu.html.twig',[
            'cat'=>$cat
        ]);
    }

}
