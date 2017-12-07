<?php


namespace App\DataFixtures;


use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $categories = [
            'Italienne',
            'Chinoise',
            'Japonaise',
            'Turque',
            'Grec',
            'Alsacienne',
            'Végétarienne',
            'Vegan',
            'Bio',
            'Marocaine',
            'Bretonne',
            'Burger',
            'Coréenne',
            'Halal',
            'Tacos',
            'Vietnamienne',
        ];

        foreach ($categories as $cat) {
            $category = new Category();
            $category->setName($cat);
            $manager->persist($category);
        }
        $manager->flush();
    }
}