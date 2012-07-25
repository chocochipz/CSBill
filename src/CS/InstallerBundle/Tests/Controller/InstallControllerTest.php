<?php

namespace CS\InstallerBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class InstallControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/installer');

        $this->assertTrue($crawler->filter('html:contains("install")')->count() > 0);
    }
}
