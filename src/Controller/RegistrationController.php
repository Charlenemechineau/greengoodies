<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\LoginFormAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{
    // Route qui permet à un utilisateur de créer un compte
    #[Route('/register', name: 'app_register')]
    public function register(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        Security $security,
        EntityManagerInterface $entityManager
    ): Response {

        // Création d'un nouvel utilisateur
        $user = new User();

        // Création du formulaire d'inscription
        $form = $this->createForm(RegistrationFormType::class, $user);

        // Récupère les données envoyées par le formulaire
        $form->handleRequest($request);

        // Vérifie que le formulaire a été envoyé et qu'il est valide
        if ($form->isSubmitted() && $form->isValid()) {

            /** @var string $plainPassword */
            $plainPassword = $form->get('plainPassword')->getData();

            // Hash le mot de passe avant enregistrement en base
            $user->setPassword(
                $userPasswordHasher->hashPassword($user, $plainPassword)
            );

            // Désactive l'accès API par défaut
            $user->setApiAccessEnabled(false);

            // Enregistre l'utilisateur en base de données
            $entityManager->persist($user);
            $entityManager->flush();

            // Connecte automatiquement l'utilisateur après l'inscription
            return $security->login(
                $user,
                LoginFormAuthenticator::class,
                'main'
            );
        }

        // Affiche la page d'inscription avec le formulaire
        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form,
        ]);
    }
}
