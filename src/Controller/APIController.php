<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class APIController extends AbstractController
{
    /**
     * @Route("/meteo", name="api_meteo")
     */
    public function meteo(SerializerInterface $seria)
    {

        $meteo = file_get_contents("https://www.prevision-meteo.ch/services/json/rieumes");
        $meteo = $seria->decode($meteo,'json');
        // dd($meteo);
        return $this->render('partial/api/meteoApi.html.twig',[
            'meteo'=>$meteo
        ]);
    }
}
