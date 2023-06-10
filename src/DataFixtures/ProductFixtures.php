<?php

namespace App\DataFixtures;

use App\Entity\Product;
use DateTime;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        for ($i = 0; $i < 150; $i++) {
            $category = $this->getReference('categoryShop-' . $faker->numberBetween(1, 6));
            $product = new Product();
            $product->setTitle($faker->sentence);
            $product->setSlug($faker->slug);
            $product->setContent($faker->text);
            $product->setOnline(true);
            $product->setCreatedAt(new DateTime('now'));
            $product->setSubtitle($faker->text(155));
            $product->setAttachement($faker->imageUrl(640, 480, 'animals', true));
            $product->setPrice($faker->randomFloat(2));
            $product->setCategory($category);

            $manager->persist($product);
        }
        $manager->flush();
    }
}
