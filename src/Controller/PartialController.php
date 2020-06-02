<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PartialController extends AbstractController
{
    /**
     * fragment entrainement plus api
     * @Route("/_Fragment", name="liste-entrainement")
     * 
     */
    public function Trainiglist()
    {
        return $this->render('partial/section/listeEntrainement.html.twig');
    }

    /**
     * fragment last News
     * @Route("/_Fragment-last-news", name="last-news")
     * 
     */
    public function lastNews()
    {
        return $this->render('partial/section/lastNews.html.twig');
    }

}
