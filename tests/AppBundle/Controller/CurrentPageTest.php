<?php
namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CurrentPageTest  extends WebTestCase
{

    /**
     * @dataProvider urlProvider
     */
    public function testRoute($url)
    {


        $client = static::createClient();

        $client->request('GET', $url);

        $this->assertResponseStatusCodeSame(200, $client->getResponse()->getStatusCode());

        echo 'La page    "' . $url . '"   possede un status code "' . $client->getResponse()->getStatusCode() . '" ;';
        echo "\n\n";
    }


    public function urlProvider()
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

        //page admin ne devrait pas repondre un satuts 200
        yield ['/admin/post'];


    }

}