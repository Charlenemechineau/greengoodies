<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils; // Permet de récupérer les erreurs de connexion et le dernier email saisi

// Controller qui va gérer la connexion et la déconnexion des utilisateurs//
class SecurityController extends AbstractController
{
    // Route qui affiche la page de connexion//
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // Permet de récupérer les erreurs de connexion//
        $error = $authenticationUtils->getLastAuthenticationError();

        // Permet de récupérer le dernier email saisi//
        $lastUsername = $authenticationUtils->getLastUsername();

        // Permet d'envoyer les données à la vue Twig de Connexion//
        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    // Route de déconnexion gérée automatiquement par Symfony//
    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException(
            'Cette méthode est gérée automatiquement par Symfony.'
        );
    }
}
