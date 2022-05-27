<?php

/**
 * Created by PhpStorm.
 * User: SAM Johnny
 * Date: 25/05/2022
 * Time: 19:08
 */

namespace App\Tests\Controller\Security;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Form;

class LoginTest extends WebTestCase
{
    private KernelBrowser $client;
    private Form $form;
    private Router $urlGenerator;

    public function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
        $this->urlGenerator = $this->client->getContainer()->get('router.default');
        $crawler = $this->client->request('GET', $this->urlGenerator->generate('app_login'));
        $this->form = $crawler->selectButton('Se connecter')->form();
    }

    public function testLoginWithBadCredentials()
    {
        $this->client->submit($this->form, [
            'username' => 'haha',
            'password' => 'hahaha'
        ]);
        $this->assertResponseRedirects($this->urlGenerator->generate('app_login'));
        $this->client->followRedirect();
        $this->assertSelectorExists('.alert.alert-danger');
    }

    public function testSuccessfullLogin()
    {
        $this->client->submit($this->form, [
            'username' => 'user1',
            'password' => 'password'
        ]);
        $this->assertResponseRedirects($this->urlGenerator->generate('app_home'));
    }

    public function testFailedLogin()
    {
        $this->client->submit($this->form, [
            'username' => 'user',
            'password' => 'passwor'
        ]);
        $this->assertResponseRedirects($this->urlGenerator->generate('app_login'));
    }
}