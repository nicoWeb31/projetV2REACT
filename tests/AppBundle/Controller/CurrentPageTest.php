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
    }



    public function urlProvider()
    {
        yield ['/'];
        yield ['/contact'];
        yield ['/login'];
        yield ['/register'];
        yield ['/tns'];
        yield ['/category/Trail'];
        yield ['/category/Trek'];
        yield ['/category/Vtt'];




    }

    

}