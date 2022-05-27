<?php

/**
 * Created by PhpStorm.
 * User: SAM Johnny
 * Date: 25/05/2022
 * Time: 12:32
 */

namespace App\Tests\Controller\User\Admin;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class AdminEditUserTest extends WebTestCase
{
    private KernelBrowser $client;
    private UserRepository $userRepository;
    private Router $urlGenerator;

    public function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
        $this->userRepository = static::getContainer()->get(UserRepository::class);
        $this->urlGenerator = $this->client->getContainer()->get('router.default');
    }

    public function testEditUserAccessDenied()
    {
        $this->client->request('GET', $this->urlGenerator->generate('user_edit', ['id' => 1]));
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        $this->assertResponseRedirects($this->urlGenerator->generate('app_login'));
    }

    public function testEditUserWithRoleAdmin()
    {
        $user = $this->userRepository->findOneBy(['username' => 'user11']);
        $this->client->loginUser($user);
        $crawler = $this->client->request('GET', $this->urlGenerator->generate('user_edit', ['id' => 1]));
        $form = $crawler->selectButton('Modifier')->form();

        $this->client->submit($form, [
            'user[username]' => "Jysaaa",
            'user[password][first]' => "password",
            'user[password][second]' => "password",
            'user[email]' => "jysaaa@hotmail.fr",
            'user[roles]' => "ROLE_ADMIN"
        ]);

        $this->client->followRedirect();
        $this->assertSelectorTextContains('div.alert.alert-success', "L'utilisateur a bien été modifié");
    }

    public function testEditUserWithRoleUser()
    {
        $user = $this->userRepository->findOneBy(['username' => 'user10']);

        $this->client->loginUser($user);
        $this->client->request('GET', $this->urlGenerator->generate('user_edit', ['id' => 1]));

        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }
}