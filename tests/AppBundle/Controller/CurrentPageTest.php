<?php
namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CurrentPageTest  extends WebTestCase
{


    /**
     * @dataProvider urlProviderPublic
     */
    public function testRoutePublic($url)
    {


        $client = static::createClient();

        $client->request('GET', $url);

        $this->assertResponseStatusCodeSame(200, $client->getResponse()->getStatusCode());

        echo "Page Public : ";
        echo 'La page    "' . $url . '"   possede un status code "' . $client->getResponse()->getStatusCode() . '" ;';
        echo "\n\n";
    }


    /**
     * route devant retourner un status code 200 ok 
     */
    public function urlProviderPublic()
    {
        //devrait passer le test
        yield ['/'];
        yield ['/contact'];
        yield ['/login'];
        yield ['/register'];
        yield ['/tns'];
        yield ['/category/Trail'];
        yield ['/category/Trek'];
        yield ['/category/Vtt'];
        yield ['/_Fragment-last-news'];

    }



    /**
     * @dataProvider urlProviderAdmin
     */
    public function testRouteAdmin($url)
    {


        $client = static::createClient();

        $client->request('GET', $url);

        $this->assertResponseStatusCodeSame(302, $client->getResponse()->getStatusCode());

        echo "Page Admin : ";
        echo 'La page    "' . $url . '"   possede un status code "' . $client->getResponse()->getStatusCode() . '" ;';
        echo "\n\n";
    }




    /**
     * route devant retourner un status code 302 ok 
     */
    public function urlProviderAdmin()
    {

        yield ['/admin/post']; 
        yield ['/admin/post-VTT'];
        yield ['/admin/post-actu'];
        yield ['/admin/users'];
        yield ['/admin/users-name'];
        yield ['/admin/users-trail'];
        yield ['/admin/users-vtt'];
        yield ['/admin/users-trek'];    
        yield ['/admin/lastNews'];

    }



}