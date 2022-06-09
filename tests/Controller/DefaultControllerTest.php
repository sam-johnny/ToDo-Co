<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class DefaultControllerTest extends WebTestCase
{
    public function setUp(): void
    {
        $client = static::createClient();
        $client->request('GET', '/');
    }

    public function testRouteHomePage()
    {
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
    }
}
