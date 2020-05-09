<?php 
namespace App\utils;

use Exception;
use Symfony\Component\Serializer\SerializerInterface;

class ApiMeteo 
{
    private $url = "https://www.prevision-meteo.ch/services/json/";
    public $seria ;

    public function __construct(SerializerInterface $seria)
    {
        $this->seria = $seria;
    }

    public function getMeteo($ville):array
    
    {

        if(isset($_GET['ville'])){

        $meteo = file_get_contents($this->url.$ville);
        $meteo = $this->seria->decode($meteo,'json');

        }else{
        $meteo =null;
        }

        //test key error and return bool for twig
        if(isset($meteo["errors"])){
            $err = true;
        }else{
                $err = false;
        }

        
        $data = [$meteo,$err];
        return  $data;
    }



}