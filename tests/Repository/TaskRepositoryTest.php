<?php

namespace App\Tests\Repository;

use App\DataFixtures\TaskFixtures;
use App\Repository\TaskRepository;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TaskRepositoryTest extends KernelTestCase
{
    /**
     * @var AbstractDatabaseTool
     */
    protected AbstractDatabaseTool $databaseTool;

    public function setUp(): void
    {
        parent::setUp();
        $this->databaseTool = static::getContainer()->get(DatabaseToolCollection::class)->get();
    }

    public function testCount()
    {
        $tasks = self::getContainer()->get(TaskRepository::class)->count([]);
        $this->databaseTool->loadFixtures([TaskFixtures::class]);

        $this->assertEquals(15, $tasks);
    }
}