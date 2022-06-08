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

class TaskFlagDoneTest extends WebTestCase
{
    private ?Router $urlGenerator;
    private KernelBrowser $client;

    public function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $user = $userRepository->findOneBy(['username' => 'user11']);
        $this->client->loginUser($user);
        $this->urlGenerator = $this->client->getContainer()->get('router.default');
    }

    public function testFlagDoneTask()
    {
        $this->client->request('GET', $this->urlGenerator->generate('task_toggle_done', ['id' => 4]));
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        $this->assertResponseRedirects($this->urlGenerator->generate('task_list'));
    }

    public function testListDoneAuthenticated()
    {
        $this->client->request('GET', $this->urlGenerator->generate('task_done_list'));
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }
}