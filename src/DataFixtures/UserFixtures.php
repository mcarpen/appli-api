<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $manager->persist(
            (new User())
                ->setUsername('admin')
                ->setEmail('admin@admin.com')
                ->setPlainPassword('123')
                ->addRole(User::ROLE_SUPER_ADMIN)
                ->setFirstName('admin')
                ->setLastName('admin')
                ->setAddress('admin')
                ->setCity('admin')
                ->setZip('00000')
        );

        $manager->persist(
            (new User())
                ->setUsername('user')
                ->setEmail('user@user.com')
                ->setPlainPassword('123')
                ->setFirstName('user')
                ->setLastName('user')
                ->setAddress('user')
                ->setCity('user')
                ->setZip('00000')
        );

        $manager->flush();
    }
}