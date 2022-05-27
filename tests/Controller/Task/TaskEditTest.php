<?php

/**
 * Created by PhpStorm.
 * User: SAM Johnny
 * Date: 25/05/2022
 * Time: 16:53
 */

namespace App\Tests\Controller\Task;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskEditTest extends WebTestCase
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

    public function testEditTaskWithRoleAdmin()
    {
        $user = $this->userRepository->findOneBy(['username' => 'user11']);

        $this->client->loginUser($user);

        $crawler = $this->client->request('GET', $this->urlGenerator->generate('task_edit', ['id' => 4]));
        $form = $crawler->selectButton('Modifier')->form();

        $this->client->submit($form, [
            'task[title]' => 'Tâche n°1',
            'task[content]' => 'Je suis la tâche n°1',
        ]);

        $this->client->followRedirect();

        $this->assertSelectorTextContains('div.alert.alert-success', 'La tâche a bien été modifiée.');
    }

    public function testEditTaskWithRoleUser()
    {
        $user = $this->userRepository->findOneBy(['username' => 'user10']);

        $this->client->loginUser($user);

        $this->client->request('GET', $this->urlGenerator->generate('task_edit', ['id' => 4]));
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('button', 'Modifier');
    }
}