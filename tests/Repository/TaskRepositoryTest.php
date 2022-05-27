<?php

namespace App\Tests\Repository;

use App\Entity\Task;
use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TaskRepositoryTest extends KernelTestCase
{

    public function testFindByIdTask()
    {
        self::bootKernel();

        $userRepository = static::getContainer()->get(TaskRepository::class);
        $tasks = $userRepository->findOneBy(['id' => '1']);

        $this->assertSame('Title1', $tasks->getTitle());
    }
}