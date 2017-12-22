<?php

namespace App\Tests;

use Symfony\Component\HttpFoundation\Response;

class ApplicationApiAvailabilityFunctionalTest extends BaseApiTestCase
{
    /**
     * @return void
     */
    public function testApiAuthenticationFailure()
    {
        $client = parent::createClient(['base_url' => getenv('BASE_URL')]);

        $client->request(
            'POST',
            '/api/login',
            array(
                '_username' => 'ezkjfbzefbzeh',
                '_password' => 'zefzefzefzefzef',
            )
        );

        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $client->getResponse()->getStatusCode());
    }

    /**
     * @return void
     */
    public function testApiAuthenticationSuccess()
    {
        $client = parent::createClient(['base_url' => getenv('BASE_URL')]);

        $client->request(
            'POST',
            '/api/login',
            array(
                '_username' => 'admin',
                '_password' => '123',
            )
        );

        $data = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertArrayHasKey('token', $data);
        $this->assertNotEmpty($data['token']);
    }
}