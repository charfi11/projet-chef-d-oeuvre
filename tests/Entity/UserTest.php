<?php

namespace App\Tests\Entity;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testUri()
    {
        $user = new User();
        $uri = "Test 2";
        
        $user->setUri($uri);
        $this->assertEquals("test_2", $user->getUri());
    }
}

?>