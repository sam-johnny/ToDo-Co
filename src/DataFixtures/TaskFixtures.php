<?php

namespace App\DataFixtures;

use App\Entity\Task;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * @codeCoverageIgnore
 */
class TaskFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i < 15; $i++) {
            $task = (new Task())
                ->setTitle("Title{$i}")
                ->setContent("Je suis la tâche n°{$i}")
                ->setIsDone(false);

            $manager->persist($task);
        }
        $manager->flush();
    }
}