<?php
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserTest extends KernelTestCase{
    public function testEntity(){
       $user = new User();
       $user->setFirstname("Jane");
       $user->setLastname("Doe");
       $user->setEmail("jane.doe@mail.com");
       $user->setPassword("azerty");
       $user->setRoles(["ROLE_ADMIN"]);

       $this->assertEquals("Jane", $user->getFirstname());
       $this->assertEquals("Doe", $user->getLastname());
       $this->assertEquals("jane.doe@mail.com", $user->getEmail());
       $this->assertEquals("azerty", $user->getPassword());
       $this->assertContains("ROLE_ADMIN", $user->getRoles());
       $this->assertEquals("jane.doe@mail.com", $user->getUserIdentifier());
    }
}