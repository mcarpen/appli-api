<?php


namespace App\Tests;


abstract class BaseApiTestCase extends BaseWebTestCase
{

    /**
     * Create a client with a default Authorization header.
     *
     * @param string $username
     * @param string $password
     *
     * @return \Symfony\Bundle\FrameworkBundle\Client
     */
    protected function createAuthenticatedClient($username = 'admin', $password = '123')
    {
        $client = parent::createClient();
        $client->request(
            'POST',
            '/api/login',
            array(
                '_username' => $username,
                '_password' => $password,
            )
        );

        $data   = json_decode($client->getResponse()->getContent(), true);
        $client = static::createClient();
        $client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $data['token']));

        return $client;
    }
}