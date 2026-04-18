<?php

// Entité User : représente un utilisateur du site GreenGoodies//

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

// Lie cette entité à la table user en base de données//
#[ORM\Entity(repositoryClass: UserRepository::class)]

// L'email doit être unique pour chaque utilisateur//
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]

class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    // Identifiant unique de l'utilisateur//
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    // Adresse email utilisée pour la connexion//
    #[ORM\Column(length: 180)]
    private ?string $email = null;

    // Rôles utilisateur (ROLE_USER, ROLE_ADMIN...)//
    #[ORM\Column]
    private array $roles = [];

    // Mot de passe hashé//
    #[ORM\Column]
    private ?string $password = null;

    // Prénom de l'utilisateur//
    #[ORM\Column(length: 255)]
    private ?string $firstName = null;

    // Nom de l'utilisateur//
    #[ORM\Column(length: 255)]
    private ?string $lastName = null;

    // Autorise ou non l'accès à l'API partenaire//
    #[ORM\Column]
    private ?bool $apiAccessEnabled = null;

    // Un utilisateur peut avoir plusieurs commandes//
    #[ORM\OneToMany(targetEntity: Order::class, mappedBy: 'user')]
    private Collection $orders;

    // Initialise la collection des commandes//
    public function __construct()
    {
        $this->orders = new ArrayCollection();
    }

    // Retourne l'identifiant utilisateur//
    public function getId(): ?int
    {
        return $this->id;
    }

    // Retourne l'email//
    public function getEmail(): ?string
    {
        return $this->email;
    }

    // Définit l'email//
    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    // Identifiant utilisé par Symfony Security//
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    // Retourne les rôles de l'utilisateur//
    public function getRoles(): array
    {
        $roles = $this->roles;

        // Garantit que chaque utilisateur possède ROLE_USER//
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    // Définit les rôles//
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    // Retourne le mot de passe hashé//
    public function getPassword(): ?string
    {
        return $this->password;
    }

    // Définit le mot de passe hashé//
    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    // Sécurise les données stockées en session//
    public function __serialize(): array
    {
        $data = (array) $this;
        $data["\0" . self::class . "\0password"] = hash('crc32c', $this->password);

        return $data;
    }

    // Supprime les données sensibles temporaires si besoin//
    public function eraseCredentials(): void
    {
    }

    // Retourne le prénom//
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    // Définit le prénom//
    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    // Retourne le nom//
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    // Définit le nom//
    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    // Retourne si l'accès API est activé//
    public function isApiAccessEnabled(): ?bool
    {
        return $this->apiAccessEnabled;
    }

    // Active ou désactive l'accès API//
    public function setApiAccessEnabled(bool $apiAccessEnabled): static
    {
        $this->apiAccessEnabled = $apiAccessEnabled;

        return $this;
    }

    // Retourne les commandes de l'utilisateur//
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    // Ajoute une commande à l'utilisateur//
    public function addOrder(Order $order): static
    {
        if (!$this->orders->contains($order)) {
            $this->orders->add($order);
            $order->setUser($this);
        }

        return $this;
    }

    // Supprime une commande de l'utilisateur//
    public function removeOrder(Order $order): static
    {
        if ($this->orders->removeElement($order)) {
            if ($order->getUser() === $this) {
                $order->setUser(null);
            }
        }

        return $this;
    }
}
