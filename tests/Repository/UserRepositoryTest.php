<?php

namespace App\Tests\Repository;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserRepositoryTest extends KernelTestCase
{
    public function testFindByIdUser()
    {
        self::bootKernel();

        $userRepository = static::getContainer()->get(UserRepository::class);
        $users = $userRepository->findOneBy(['id' => '1']);

        $this->assertSame('user1', $users->getUsername());
    }
}