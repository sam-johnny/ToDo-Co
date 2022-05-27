<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function setUp(): void
    {
        $client = static::createClient();
        $client->request('GET', '/');
    }

    public function testRouteHomePage()
    {
        $this->assertResponseStatusCodeSame(200);
    }

    public function testH1HomePage()
    {
        $this->assertSelectorTextContains(
            'h1',
            "Bienvenue sur Todo List, l'application vous permettant de gérer l'ensemble de vos tâches sans effort !"
        );
    }
}