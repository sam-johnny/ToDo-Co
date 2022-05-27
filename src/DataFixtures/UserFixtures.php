<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * @codeCoverageIgnore
 */
class UserFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i < 11; $i++) {
            $user = (new User())
                ->setEmail("user{$i}@hotmail.fr")
                ->setPassword(password_hash("password", PASSWORD_BCRYPT))
                ->setUsername("user{$i}")
                ->setRoles(['ROLE_USER']);

            $manager->persist($user);
        }

        $user = (new User())
            ->setEmail("user11@hotmail.fr")
            ->setPassword(password_hash("password", PASSWORD_BCRYPT))
            ->setUsername("user11")
            ->setRoles(['ROLE_ADMIN']);

        $manager->persist($user);

        $manager->flush();
    }
}