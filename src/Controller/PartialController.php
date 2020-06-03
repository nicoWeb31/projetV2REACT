<?php

namespace App\Controller;

use App\Entity\LastNews;
use App\Repository\LastNewsRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
    public function lastNews(LastNewsRepository $repo)
    {

        $lastnews = $repo->findAll();

        return $this->render('partial/section/lastNews.html.twig',[
            'LastNews'=>$lastnews
        ]);
    }

}
