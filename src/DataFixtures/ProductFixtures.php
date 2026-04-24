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
                'name' => "Kit d'hygiène recyclable",
                'price' => 24.99,
                'picture' => 'produit_1.png',
                'short' => 'Pour une salle de bain éco-friendly',
                'full' => "Ce kit d’hygiène recyclable est conçu pour celles et ceux qui souhaitent allier bien-être et respect de l’environnement.
                Il contient l’essentiel pour une routine quotidienne complète, sans compromis sur la qualité ni sur la planète.
                Chaque élément du kit est fabriqué à partir de matériaux durables, recyclables ou biodégradables, afin de limiter au maximum l'empreinte écologique.
                Que ce soit pour une utilisation personnelle, en voyage ou en cadeau responsable, ce kit est idéal pour amorcer une transition vers une consommation plus consciente.
                Il s'inscrit parfaitement dans une démarche zéro déchet, en remplaçant les produits jetables par des alternatives durables et réutilisables."
                            ],

            [
                'name' => 'Shot Tropical',
                'price' => 4.50,
                'picture' => 'produit_2.png',
                'short' => 'Fruits frais, pressés à froid',
                'full' => "Offrez-vous un concentré d’énergie naturelle avec notre shot tropical pressé à froid, élaboré à partir de fruits frais issus de l’agriculture responsable.
                Mangue, ananas, passion et citron vert sont pressés à froid pour préserver un maximum de nutriments sans recourir à la chaleur ni à aucun additif.
                Conditionné dans un flacon en verre recyclable, ce shot s’inscrit dans une démarche durable et zéro plastique.
                Idéal pour soutenir votre système immunitaire tout en réduisant votre impact environnemental, il allie plaisir gustatif et conscience écologique."
            ],

            [
                'name' => 'Gourde en bois',
                'price' => 16.90,
                'picture' => 'produit_3.png',
                'short' => "50cl, bois d'olivier",
                'full' => "Alliez élégance et conscience écologique avec cette gourde en bois durable.
                Fabriquée à partir de bois issu de forêts gérées durablement, elle est doublée d’un contenant inox pour garantir une parfaite étanchéité et une conservation optimale des boissons chaudes ou froides.
                Sa conception sans plastique, réutilisable à l’infini, en fait une alternative idéale aux bouteilles jetables.
                Solide, stylée et responsable, cette gourde s’adresse à celles et ceux qui veulent consommer autrement, avec respect pour la nature à chaque gorgée."
            ],

            [
                'name' => 'Disques Démaquillants x3',
                'price' => 19.90,
                'picture' => 'produit_4.png',
                'short' => 'Solution efficace pour vous démaquiller en douceur',
                'full' => "Fini les cotons jetables ! Optez pour une routine beauté plus responsable avec ces disques démaquillants lavables et réutilisables.

                Fabriqués en coton bio ou en bambou certifié, ils sont ultra-doux pour la peau, même la plus sensible, tout en respectant l’environnement.

                Lavables en machine, ils remplacent des centaines de cotons à usage unique et s’inscrivent parfaitement dans une démarche zéro déchet.

                Un petit geste au quotidien, pour un grand impact sur la planète."
            ],

            [
                'name' => 'Bougie Lavande & Patchouli',
                'price' => 32.00,
                'picture' => 'produit_5.png',
                'short' => 'Cire naturelle',
                'full' => "Laissez-vous envelopper par l’harmonie apaisante de la lavande et la profondeur boisée du patchouli avec cette bougie naturelle, coulée à la main.

                Composée de cire végétale 100 % naturelle (soja ou colza), d'une mèche en coton non traité et d’huiles essentielles biologiques, elle ne dégage aucune substance toxique.

                Son contenant en verre recyclable ou réutilisable renforce sa dimension écoresponsable.

                Idéale pour créer une ambiance relaxante, cette bougie s’inscrit dans une consommation douce, durable et respectueuse de l’environnement."
            ],

            [
                'name' => 'Brosse à dent',
                'price' => 59.99,
                'picture' => 'produit_6.png',
                'short' => 'Bois de hêtre rouge issu de forêts gérées durablement',
                'full' => "Remplacez le plastique de votre salle de bain avec cette brosse à dents en bois naturelle, conçue pour limiter votre impact environnemental sans compromettre votre hygiène bucco-dentaire.

                Son manche est fabriqué en bois de bambou 100 % biodégradable, issu de forêts gérées durablement, et ses poils doux sans BPA assurent un brossage efficace tout en respectant vos gencives.

                Une alternative simple et responsable pour réduire vos déchets au quotidien."
            ],

            [
                'name' => 'Kit couvert en bois',
                'price' => 12.30,
                'picture' => 'produit_7.png',
                'short' => 'Revêtement Bio en olivier & sac de transport',
                'full' => "Emportez vos couverts partout avec ce kit en bois d’olivier, comprenant une fourchette, un couteau et une cuillère, le tout présenté dans un élégant sac de transport.

                Idéal pour les pique-niques, les repas en extérieur ou au bureau, ce kit est une alternative durable aux couverts jetables.

                Chaque pièce est soigneusement fabriquée à partir de bois d’olivier, connu pour sa durabilité et sa résistance à l’eau.

                Un choix écoresponsable pour réduire vos déchets au quotidien."
            ],

            [
                'name' => 'Nécessaire, déodorant Bio',
                'price' => 8.50,
                'picture' => 'produit_8.png',
                'short' => "50ml déodorant à l’eucalyptus",
                'full' => "Ce déodorant bio à l’eucalyptus offre une protection efficace tout en respectant votre peau.

                Sa formule naturelle, sans sels d’aluminium ni parabènes, garantit une sensation de fraîcheur durable.

                Enrichi en huiles essentielles, il laisse un parfum agréable et subtil.

                Son format de 50ml est idéal pour une utilisation quotidienne et se glisse facilement dans votre trousse de toilette.

                Optez pour une hygiène responsable avec ce déodorant respectueux de l’environnement."
            ],

            [
                'name' => 'Savon Bio',
                'price' => 18.90,
                'picture' => 'produit_9.png',
                'short' => 'Thé, Orange & Girofle',
                'full' => "Savon bio artisanal, fabriqué à partir d'ingrédients naturels et d'huiles essentielles.

                Ce savon doux et parfumé nettoie la peau en profondeur tout en respectant son équilibre naturel.

                Idéal pour tous les types de peau, il laisse une sensation de fraîcheur et de bien-être.

                Un choix écoresponsable pour votre routine de soins."
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
