<?php

namespace App\DataFixtures;

use App\Entity\CategoryShop;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CategoryShopFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $c = [
            1 => [
                'name' => 'Robes',
                'slug' => 'robes',
                'description' => 'kokrtggrst'
            ],
            2 => [
                'name' => 'T-shirts',
                'slug' => 't-shirts',
                'description' => 'kokrtggrst'
            ],
            3 => [
                'name' => 'Sacs',
                'slug' => 'sacs',
                'description' => 'vkokrtggrst'
            ],
            4 => [
                'name' => 'Vestes',
                'slug' => 'vestes',
                'description' => 'kokrtggrst'
            ],
            5 => [
                'name' => 'Bonnets',
                'slug' => 'bonnets',
                'description' => 'kokrtggrst'
            ],
            6 => [
                'name' => 'Chaussures',
                'slug' => 'chaussures',
                'description' => 'kokrtggrst'
            ],
            7 => [
                'name' => 'Jeans',
                'slug' => 'jeans',
                'description' => 'kokrtggrst'
            ]
        ];

        foreach ($c as $k => $value) {
            $categoryShop = new CategoryShop();
            $categoryShop->setName($value['name']);
            $categoryShop->setSlug($value['slug']);
            $categoryShop->setDescription($value['description']);
            $manager->persist($categoryShop);
            $this->addReference('categoryShop-' . $k, $categoryShop);
        }

        $manager->flush();
    }
}
