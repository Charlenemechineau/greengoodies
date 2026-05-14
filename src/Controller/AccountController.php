<?php

namespace App\Controller;

use App\Repository\OrderRepository; // Me permet de récupérer les commandes de l'utilisateur connecté//
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted; // Me permet de restreindre l'accès à la page de compte uniquement aux utilisateurs connectés//

final class AccountController extends AbstractController
{
    // Cette route permet d'afficher la page de compte de l'utilisateur connecté//
    // avec la liste de ses commandes validées//
    #[Route('/account', name: 'app_account')]
    #[IsGranted('ROLE_USER')] // Seuls les utilisateurs connectés peuvent accéder à cette page//
    public function index(OrderRepository $orderRepository): Response
    {
        // Permet de récupérer les commandes de l'utilisateur connecté//
        $orders = $orderRepository->findBy(
            [
                'user' => $this->getUser(), // utilisateur connecté//
                'status' => 'validated', // uniquement les commandes validées//
            ],
            [
                'validatedAt' => 'DESC', // tri par date décroissante//
            ]
        );

        // Permet d'envoyer les commandes sur la page mon compte//
        return $this->render('account/index.html.twig', [
            'orders' => $orders,
        ]);
    }
}
