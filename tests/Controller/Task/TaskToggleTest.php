<?php

/**
 * Created by PhpStorm.
 * User: SAM Johnny
 * Date: 25/05/2022
 * Time: 18:36
 */

namespace App\Tests\Controller\Task;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class TaskToggleTest extends WebTestCase
{
    private ?Router $urlGenerator;

    public function setUp(): void
    {
        parent::setUp();
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $user = $userRepository->findOneBy(['username' => 'user11']);
        $client->loginUser($user);
        $this->urlGenerator = $client->getContainer()->get('router.default');
        $client->request('GET', $this->urlGenerator->generate('task_toggle', ['id' => 4]));
    }

    public function testToggleTask()
    {
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        $this->assertResponseRedirects($this->urlGenerator->generate('task_list'));
    }
}