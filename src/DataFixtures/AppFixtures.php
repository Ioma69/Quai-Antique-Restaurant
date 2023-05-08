<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use App\Entity\Dishes;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $passwordHasher;
    public function __construct(UserPasswordHasherInterface $passwordHasher) {
        $this->passwordHasher = $passwordHasher;
        
    }

    public function load(ObjectManager $manager): void
    {
         $john = new Admin($this->passwordHasher);
         $john->setEmail("test@hotmail.com")->setPassword("123")->setRoles(["ROLE_ADMIN"]);
         $manager->persist($john);
         
         $utilisateur = new User($this->passwordHasher);
         $utilisateur->setEmail("user@hotmail.com")->setPassword("user")->setRoles(["ROLE_USER"]);
         $manager->persist($utilisateur);


         $manager->flush();

    }

    
}
