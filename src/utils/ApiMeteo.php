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
        try{

            $meteo = file_get_contents($this->url.$ville,0, stream_context_create(["http"=>["timeout"=>1.5]]));
            $meteo = $this->seria->decode($meteo,'json');
        }catch(Exception $e){
            //echo $e->getMessage();
            $meteo =null;
        }

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