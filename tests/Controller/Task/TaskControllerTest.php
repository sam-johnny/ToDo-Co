<?php

/**
 * Created by PhpStorm.
 * User: SAM Johnny
 * Date: 19/05/2022
 * Time: 12:34
 */

namespace App\Tests\Controller\Task;

use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class TaskControllerTest extends WebTestCase
{
    private ?KernelBrowser $client = null;
    private TaskRepository $taskRepository;
    private ?Router $urlGenerator;

    public function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
        $this->taskRepository = static::getContainer()->get(TaskRepository::class);
        $this->urlGenerator = $this->client->getContainer()->get('router.default');
    }

    public function testRouteTaskPage()
    {
        $this->client->request('GET', $this->urlGenerator->generate('task_list'));
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
    }

    public function testRouteListDone()
    {
        $this->client->request('GET', $this->urlGenerator->generate('task_done_list'));
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
    }

    public function testTaskCreateRoute()
    {
        $this->client->request('GET', $this->urlGenerator->generate('task_create'));
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
    }

    public function testTasksCreateRedirectToLogin()
    {
        $this->client->request('GET', $this->urlGenerator->generate('task_create'));
        $this->assertResponseRedirects($this->urlGenerator->generate('app_login'));
    }

    public function testListTasks()
    {
        $this->client->request('GET', $this->urlGenerator->generate('task_list'));
        $users = count($this->taskRepository->findAll());
        $this->assertEquals(11, $users);
    }

    public function testEditTaskRoute()
    {
        $this->client->request('GET', $this->urlGenerator->generate('task_edit', ['id' => 2]));
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
    }

    public function testEditTaskRedirectToLogin()
    {
        $this->client->request('GET', $this->urlGenerator->generate('task_edit', ['id' => 2]));
        $this->assertResponseRedirects($this->urlGenerator->generate('app_login'));
    }

    public function testTaskDeleteRoute()
    {
        $this->client->request('GET', $this->urlGenerator->generate('task_delete', ['id' => 4]));
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
    }

    public function testDeleteTaskRedirectToLogin()
    {
        $this->client->request('GET', $this->urlGenerator->generate('task_delete', ['id' => 4]));
        $this->assertResponseRedirects($this->urlGenerator->generate('app_login'));
    }

    public function testFlagDoneTaskRoute()
    {
        $this->client->request('GET', $this->urlGenerator->generate('task_toggle_done', ['id' => 2]));
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
    }

    public function testFlagDoneRedirectToLogin()
    {
        $this->client->request('GET', $this->urlGenerator->generate('task_toggle_done', ['id' => 2]));
        $this->assertResponseRedirects($this->urlGenerator->generate('app_login'));
    }
}