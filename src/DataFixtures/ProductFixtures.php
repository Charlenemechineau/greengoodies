<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $products = [

            [
                'name' => 'Kit d\'hygiène recyclable',
                'price' => 24.99,
                'picture' => 'produit_1.png',
                'short' => 'Pour une salle de bain éco-friendly',
                'full' => 'Kit d’hygiène durable conçu pour réduire les déchets du quotidien.'
            ],

            [
                'name' => 'Shot Tropical',
                'price' => 4.50,
                'picture' => 'produit_2.png',
                'short' => 'Fruits frais, pressés à froid',
                'full' => 'Shot vitaminé à base de mangue, ananas et passion.'
            ],

            [
                'name' => 'Gourde en bois',
                'price' => 16.90,
                'picture' => 'produit_3.png',
                'short' => '50cl, bois d\'olivier',
                'full' => 'Gourde écologique avec finition bois naturel.'
            ],

            [
                'name' => 'Disques Démaquillants x3',
                'price' => 19.90,
                'picture' => 'produit_4.png',
                'short' => 'Solution efficace pour vous démaquiller en douceur',
                'full' => 'Disques lavables et réutilisables pour une routine zéro déchet.'
            ],

            [
                'name' => 'Bougie Lavande & Patchouli',
                'price' => 32.00,
                'picture' => 'produit_5.png',
                'short' => 'Cire naturelle',
                'full' => 'Bougie artisanale naturelle aux huiles essentielles.'
            ],

            [
                'name' => 'Brosse à dent',
                'price' => 59.99,
                'picture' => 'produit_6.png',
                'short' => 'Bois de hêtre rouge',
                'full' => 'Brosse à dents écologique en bois durable.'
            ],

            [
                'name' => 'Kit couvert en bois',
                'price' => 12.30,
                'picture' => 'produit_7.png',
                'short' => 'Revêtement Bio en olivier',
                'full' => 'Kit de couverts réutilisables avec housse transport.'
            ],

            [
                'name' => 'Nécessaire, déodorant Bio',
                'price' => 8.50,
                'picture' => 'produit_8.png',
                'short' => '50ml déodorant à l’eucalyptus',
                'full' => 'Déodorant naturel bio efficace et doux.'
            ],

            [
                'name' => 'Savon Bio',
                'price' => 18.90,
                'picture' => 'produit_9.png',
                'short' => 'Thé, Orange & Girofle',
                'full' => 'Savon artisanal aux huiles essentielles.'
            ],

        ];

        foreach ($products as $data) {
            $product = new Product();

            $product->setName($data['name']);
            $product->setPrice($data['price']);
            $product->setPicture($data['picture']);
            $product->setShortDescription($data['short']);
            $product->setFullDescription($data['full']);

            $manager->persist($product);
        }

        $manager->flush();
    }
}
