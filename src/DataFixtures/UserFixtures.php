<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setEmail("user{$i}@hotmail.fr");
            $user->setPassword(password_hash("password", PASSWORD_BCRYPT));
            $user->setUsername("user{$i}");

            $manager->persist($user);
        }
        $manager->flush();
    }
}