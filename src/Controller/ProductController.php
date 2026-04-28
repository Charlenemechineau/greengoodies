<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProductController extends AbstractController
{
    //Route pour afficher la fiche d'un produit, avec son nom et son id//
    #[Route('/product/{id<\d+>}', name: 'app_product_detail')]
    public function show(Product $product): Response
    {
        // permet d'envoyer les données du produit à la vue de la fiche produit//
        return $this->render('product/detail.html.twig', [
            'product' => $product,
        ]);
    }
}
