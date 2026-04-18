<?php

// Entité Order : représente une commande client ou un panier en cours//

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

// Lie cette entité à la table "order" en base de données//
#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    // Identifiant unique de la commande//
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    // Statut de la commande : cart / validated//
    #[ORM\Column(length: 50)]
    private ?string $status = null;

    // Date de création de la commande//
    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    // Date de validation de la commande (nullable tant que panier)//
    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $validatedAt = null;

    // Montant total de la commande//
    #[ORM\Column(nullable: true)]
    private ?float $totalPrice = null;

    // Plusieurs commandes peuvent appartenir à un utilisateur//
    #[ORM\ManyToOne(inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    // Une commande contient plusieurs lignes de commande//
    #[ORM\OneToMany(
        targetEntity: OrderItem::class,
        mappedBy: 'customerOrder',
        orphanRemoval: true
    )]
    private Collection $orderItems;

    // Initialise la collection des lignes de commande//
    public function __construct()
    {
        $this->orderItems = new ArrayCollection();
    }

    // Retourne l'id de la commande//
    public function getId(): ?int
    {
        return $this->id;
    }

    // Retourne le statut//
    public function getStatus(): ?string
    {
        return $this->status;
    }

    // Définit le statut//
    public function setStatus(string $status): static
    {
        $this->status = $status;
        return $this;
    }

    // Retourne la date de création//
    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    // Définit la date de création//
    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    // Retourne la date de validation//
    public function getValidatedAt(): ?\DateTimeImmutable
    {
        return $this->validatedAt;
    }

    // Définit la date de validation//
    public function setValidatedAt(?\DateTimeImmutable $validatedAt): static
    {
        $this->validatedAt = $validatedAt;
        return $this;
    }

    // Retourne le total de la commande//
    public function getTotalPrice(): ?float
    {
        return $this->totalPrice;
    }

    // Définit le total de la commande//
    public function setTotalPrice(?float $totalPrice): static
    {
        $this->totalPrice = $totalPrice;
        return $this;
    }

    // Retourne l'utilisateur lié à la commande//
    public function getUser(): ?User
    {
        return $this->user;
    }

    // Associe un utilisateur à la commande//
    public function setUser(?User $user): static
    {
        $this->user = $user;
        return $this;
    }

    // Retourne les lignes de commande//
    public function getOrderItems(): Collection
    {
        return $this->orderItems;
    }

    // Ajoute une ligne de commande//
    public function addOrderItem(OrderItem $orderItem): static
    {
        if (!$this->orderItems->contains($orderItem)) {
            $this->orderItems->add($orderItem);
            $orderItem->setCustomerOrder($this);
        }

        return $this;
    }

    // Supprime une ligne de commande//
    public function removeOrderItem(OrderItem $orderItem): static
    {
        if ($this->orderItems->removeElement($orderItem)) {
            if ($orderItem->getCustomerOrder() === $this) {
                $orderItem->setCustomerOrder(null);
            }
        }

        return $this;
    }
}
