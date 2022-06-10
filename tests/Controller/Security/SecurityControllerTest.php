<?php

namespace App\Tests\Controller\Security;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class SecurityControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private Router $urlGenerator;

    public function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
        $this->urlGenerator = $this->client->getContainer()->get('router.default');
    }

    public function testLoginPage()
    {
        $this->client->request('GET', $this->urlGenerator->generate('app_login'));
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorTextContains('button', 'Se connecter');
        $this->assertSelectorNotExists('.alert.alert-danger');
    }

    public function testLogoutPage()
    {
        $this->client->request('GET', $this->urlGenerator->generate('app_logout'));
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
    }
}
