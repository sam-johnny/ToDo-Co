<?php

/**
 * Created by PhpStorm.
 * User: SAM Johnny
 * Date: 25/05/2022
 * Time: 17:45
 */

namespace App\Tests\Controller\Task;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class TaskDeleteTest extends WebTestCase
{
    private ?KernelBrowser $client = null;
    private UserRepository $userRepository;
    private ?Router $urlGenerator;

    public function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
        $this->userRepository = static::getContainer()->get(UserRepository::class);
        $this->urlGenerator = $this->client->getContainer()->get('router.default');
    }

    public function testDeleteTaskWithRoleAdmin()
    {
        $user = $this->userRepository->findOneBy(['username' => 'user11']);
        $this->client->loginUser($user);
        $this->client->request('GET', $this->urlGenerator->generate('task_delete', ['id' => 1]));

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        $this->assertResponseRedirects($this->urlGenerator->generate('task_list'));
    }

    public function testDeleteTaskWithRoleUser()
    {
        $user = $this->userRepository->findOneBy(['username' => 'user1']);
        $this->client->loginUser($user);
        $this->client->request('GET', $this->urlGenerator->generate('task_delete', ['id' => 1]));

        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }
}