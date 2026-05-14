<?php

namespace App\Controller;

use App\Repository\OrderRepository; // Me permet de récupérer les commandes de l'utilisateur connecté//
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted; // Me permet de restreindre l'accès à la page de compte uniquement aux utilisateurs connectés//
use Doctrine\ORM\EntityManagerInterface; // Me  permet de gérer les entités et les requêtes en base de données//
use Symfony\Component\HttpFoundation\Request; // Me permet de gérer les requêtes HTTP et de récupérer les données envoyées par les formulaires//

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

    // Cette route permet de supprimer le compte de l'utilisateur connecté
    #[Route('/account/delete', name: 'app_account_delete')]
    #[IsGranted('ROLE_USER')]
    public function delete(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        // On récupère l'utilisateur actuellement connecté
        $user = $this->getUser();

        // On supprime l'utilisateur en base de données
        $entityManager->remove($user);
        $entityManager->flush();

        // On déconnecte l'utilisateur en vidant la session après la suppression
        $request->getSession()->invalidate();

        // On redirige vers la page d'accueil
        return $this->redirectToRoute('app_home');
    }
}
