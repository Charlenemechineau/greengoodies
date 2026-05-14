<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

// Formulaire d'inscription utilisateur
class RegistrationFormType extends AbstractType
{
    // Permet de construire le formulaire
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            // Champ email
            ->add('email')

            // Champ nom
            ->add('lastName')

            // Champ prénom
            ->add('firstName')

            // Checkbox pour accepter les conditions
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,

                // Vérifie que la case est cochée
                'constraints' => [
                    new IsTrue(message: 'Vous devez accepter les conditions.'),
                ],
            ])

            // Champ mot de passe avec confirmation
            ->add('plainPassword', RepeatedType::class, [

                // Type password
                'type' => PasswordType::class,

                // Ce champ n'est pas directement lié à l'entité User
                'mapped' => false,

                // Message si les mots de passe sont différents
                'invalid_message' => 'Les deux mots de passe ne correspondent pas.',

                // Premier champ mot de passe
                'first_options' => [
                    'label' => 'Mot de passe',
                    'attr' => ['autocomplete' => 'new-password'],
                ],

                // Champ confirmation mot de passe
                'second_options' => [
                    'label' => 'Confirmation mot de passe',
                    'attr' => ['autocomplete' => 'new-password'],
                ],

                // Vérifications du mot de passe
                'constraints' => [

                    // Vérifie que le champ n'est pas vide
                    new NotBlank(message: 'Veuillez saisir un mot de passe'),

                    // Vérifie la longueur minimale
                    new Length(
                        min: 6,
                        minMessage: 'Votre mot de passe doit contenir au moins {{ limit }} caractères',
                        max: 4096
                    ),
                ],
            ])
        ;
    }

    // Lie ce formulaire à l'entité User
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
