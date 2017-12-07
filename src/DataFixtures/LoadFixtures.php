<?php


namespace App\DataFixtures;


use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Nelmio\Alice\Loader\NativeLoader;

class LoadFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $loader    = new NativeLoader();
        $objectSet = $loader->loadFile(__DIR__ . '/fixtures.yml')->getObjects();
        foreach ($objectSet as $obj) {
            $manager->persist($obj);
        }
        $manager->flush();
    }
}