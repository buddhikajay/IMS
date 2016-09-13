<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

// todo check & remove
class RandomControllerTest extends WebTestCase
{
    public function testNumber()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/number');
    }

}
