<?php
namespace Tests\Repository;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;


class UserRepositoryTest  extends KernelTestCase
{

    /**
     * tester le nbre de tuple en bdd
     */
    public function testCount(){
        self::bootKernel();
        $user = self::$container->get(UserRepository::class)->count([]);
        $this->assertEquals(11, $user);
        echo "Tuple dans users :  $user ";
}
}