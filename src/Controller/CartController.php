<?php

namespace App\Controller;

use App\Entity\Product; //permet d'utiliser l'entité product pour récupérer un produit grace à son id//
use App\Repository\ProductRepository; // permet de venir recupéré en base un produit graçe a son id//
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;//permet de stocker les données du panier en session utilisateur//
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Order; //Me permet d'utiliser l'entité Order pour créer une commande à partir du panier//
use App\Entity\OrderItem; //Me permet d'utiliser l'entité OrderItem pour créer les lignes de commande à partir du panier//
use Doctrine\ORM\EntityManagerInterface; // Me permet d'interagir avec la base de données pour enregistrer la commande et les lignes de commande//

final class CartController extends AbstractController
{
    //permet d'afficher ma page panier avec son contenu//
    #[Route('/cart', name: 'app_cart')]
    public function index(SessionInterface $session, ProductRepository $productRepository): Response
    {
        //permet de récupéré le panier stocké en session//
        $cart = $session->get('cart', []);

        //Tableau qui contiendra les données complétes
        $cartWithData = [];
        // variable du total de mon panier//
        $total = 0;

        // On parcourt chaque produit du panier//
        foreach ($cart as $id => $quantity) {
            // Je récupère le produit en base grâce à son id//
            $product = $productRepository->find($id);
            // Si le produit existe//
            if ($product) {
                //  je calcul du total de la ligne//
                // prix x quantité//
                $lineTotal = $product->getPrice() * $quantity;

                //  je stoque les infos dans un tableau//
                $cartWithData[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'lineTotal' => $lineTotal,
                ];
                //j'ajoute le total général//
                $total += $lineTotal;
            }
        }
        //permet d'envoyé les données à la vue de mon panier//
        return $this->render('cart/cart.html.twig', [
            'items' => $cartWithData,
            'total' => $total,
        ]);
    }

    // Route pour ajouter un produit au panier//
    #[Route('/cart/add/{id<\d+>}', name: 'app_cart_add')]
    public function add(Product $product, SessionInterface $session): Response
    {
        //Je récupére le panier stocké en session, ou un tableau vide s'il n'existe pas encore//
        $cart = $session->get('cart', []);
        //je récupére l'id de mon produit//
        $id = $product->getId();
        // Si déjà présent : on augmente quantité//
        if (isset($cart[$id])) {
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }
        //Je sauvegarde le panier en session//
        $session->set('cart', $cart);
        // Redirection vers la page panier
        return $this->redirectToRoute('app_cart');
    }

    //Route pour supprimer un produit du panier //
    #[Route('/cart/remove/{id<\d+>}', name: 'app_cart_remove')]
    public function remove(Product $product, SessionInterface $session): Response
    {
        // Je récupère le panier //
        $cart = $session->get('cart', []);

        //supprime le produit grâce à son id//
        unset($cart[$product->getId()]);

        //Met à jour la session//
        $session->set('cart', $cart);

        //Et rédirige sur le panier//
        return $this->redirectToRoute('app_cart');
    }

    //Route pour vider le panier//
    #[Route('/cart/clear', name: 'app_cart_clear')]
    public function clear(SessionInterface $session): Response
    {
        //Je supprime totalement la session panier//
        $session->remove('cart');

        //Redirige ensuite vers mon panier vide//
        return $this->redirectToRoute('app_cart');

    }
    // Route qui permet de valider le panier
// et de créer une commande à partir de son contenu
    #[Route('/cart/validate', name: 'app_cart_validate')]
    public function validateCart(
        SessionInterface       $session, // Permet de récupérer le panier stocké en session//
        ProductRepository      $productRepository, // Permet de récupérer les produits en base//
        EntityManagerInterface $entityManager // Permet d'enregistrer la commande en base//
    ): Response
    {
        // Vérifie que l'utilisateur est connecté//
        $this->denyAccessUnlessGranted('ROLE_USER');

        // Récupère le panier en session//
        $cart = $session->get('cart', []);

        // Si le panier est vide, on redirige vers la page panier//
        if (empty($cart)) {
            return $this->redirectToRoute('app_cart');
        }

        // Création de la commande//
        $order = new Order();
        $order->setUser($this->getUser());
        $order->setStatus('validated');
        $order->setCreatedAt(new \DateTimeImmutable());
        $order->setValidatedAt(new \DateTimeImmutable());

        // Variable qui contiendra le montant total de la commande//
        $total = 0;

        // Parcourt chaque produit du panier//
        foreach ($cart as $id => $quantity) {
            $product = $productRepository->find($id);

            // Si le produit n'existe plus en base, on l'ignore//
            if (!$product) {
                continue;
            }

            // Calcule le total de la ligne//
            $lineTotal = $product->getPrice() * $quantity;

            // Création d'une ligne de commande//
            $orderItem = new OrderItem();
            $orderItem->setProduct($product);
            $orderItem->setQuantity($quantity);
            $orderItem->setUnitPrice($product->getPrice());
            $orderItem->setTotalPrice($lineTotal);

            // Associe la ligne à la commande//
            $order->addOrderItem($orderItem);

            // Demande à Doctrine d'enregistrer la ligne de commande//
            $entityManager->persist($orderItem);

            // Ajoute le total de la ligne au total général//
            $total += $lineTotal;
        }

        // Définit le total final de la commande//
        $order->setTotalPrice($total);

        // Enregistre la commande en base//
        $entityManager->persist($order);
        $entityManager->flush();

        // Vide le panier après validation//
        $session->remove('cart');

        // Message de confirmation affiché à l'utilisateur//
        $this->addFlash(
            'success',
            'Votre commande a été validée avec succès !'
        );

        return $this->redirectToRoute('app_cart');
    }
}
