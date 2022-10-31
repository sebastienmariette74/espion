<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $userPasswordHasher ){}
    
    public function load(ObjectManager $manager): void
    {        
        $admin = new User();

        $admin   
            ->setEmail('admin@gmail.com')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $admin,
                    'admin'
                )
            );

        $manager->persist($admin);

        $manager->flush();
    }
}
