<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
    ) {
    }
    public function load(ObjectManager $manager): void
    {
        for($i=0; $i<3; $i++){
            $user = new User();
            $user->setFirstname("firstname".$i);
            $user->setLastname("lastname".$i);
            $user->setEmail("email".$i."@mail.com");
            $user->setPassword($this->passwordHasher->hashPassword($user, "azerty"));
    
            $manager->persist($user);
        }
        
        $manager->flush();
    }
}
