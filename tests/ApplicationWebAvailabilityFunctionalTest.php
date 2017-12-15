<?php

namespace App\Tests;

use Symfony\Component\HttpFoundation\Request;

class ApplicationWebAvailabilityFunctionalTest extends BaseWebTestCase
{
    /**
 * @dataProvider urlProvider
 *
 * @param $url string The relative URL to test.
 */
    public function testPageIsSuccessful($url)
    {
        $client = static::createClient();
        $client->request(Request::METHOD_GET, $url);

        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    /**
     * @dataProvider urlRedirectedProvider
     *
     * @param $url string The relative URL to test.
     */
    public function testPageIsSuccessfulyRedirected($url)
    {
        $client = static::createClient();
        $client->request(Request::METHOD_GET, $url);

        $this->assertTrue($client->getResponse()->isRedirection());
    }

    /**
     * @return \Generator
     */
    public function urlProvider()
    {
        yield ['/'];
        yield ['/login'];
    }

    /**
     * @return \Generator
     */
    public function urlRedirectedProvider()
    {
        yield ['/admin'];
    }
}