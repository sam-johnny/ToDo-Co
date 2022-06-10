<?php

/**
 * Created by PhpStorm.
 * User: SAM Johnny
 * Date: 25/05/2022
 * Time: 16:45
 */

namespace App\Tests\Controller\Task;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskCreateTest extends WebTestCase
{
    private ?KernelBrowser $client = null;
    private UserRepository $userRepository;
    private Router $urlGenerator;

    public function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
        $this->userRepository = static::getContainer()->get(UserRepository::class);
        $this->urlGenerator = $this->client->getContainer()->get('router.default');
    }

    public function testCreateTaskWithRoleAdmin()
    {
        $user = $this->userRepository->findOneBy(['username' => 'user11']);

        $this->client->loginUser($user);

        $crawler = $this->client->request('GET', $this->urlGenerator->generate('task_create'));
        $form = $crawler->selectButton('Ajouter')->form();

        $this->client->submit($form, [
            'task[title]' => 'Tâche n°1',
            'task[content]' => 'Je suis la tâche n°1'
        ]);

        $this->client->followRedirect();

        $this->assertSelectorTextContains('div.alert.alert-success', 'La tâche a été bien été ajoutée.');
    }

    public function testCreateTaskWithRoleUser()
    {
        $user = $this->userRepository->findOneBy(['username' => 'user10']);

        $this->client->loginUser($user);

        $crawler = $this->client->request('GET', $this->urlGenerator->generate('task_create'));
        $form = $crawler->selectButton('Ajouter')->form();

        $this->client->submit($form, [
            'task[title]' => 'Tâche n°1',
            'task[content]' => 'Je suis la tâche n°1'
        ]);

        $this->client->followRedirect();

        $this->assertSelectorTextContains('div.alert.alert-success', 'La tâche a été bien été ajoutée.');
    }
}
