<?php


namespace App\Tests;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class BaseWebTestCase extends WebTestCase
{
    protected static function createClient(array $options = array(), array $server = array())
    {
        return parent::createClient(
            array_unique(array_merge($options, ['base_url' => getenv('BASE_URL')])),
            $server
        );
    }
}