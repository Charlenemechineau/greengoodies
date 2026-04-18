<?php

// Entité OrderItem : représente une ligne de commande//

namespace App\Entity;

use App\Repository\OrderItemRepository;
use Doctrine\ORM\Mapping as ORM;

// Lie cette entité à la table order_item en base de données//
#[ORM\Entity(repositoryClass: OrderItemRepository::class)]
class OrderItem
{
    // Identifiant unique de la ligne de commande//
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    // Quantité du produit commandé//
    #[ORM\Column]
    private ?int $quantity = null;

    // Prix unitaire du produit au moment de la commande//
    #[ORM\Column]
    private ?float $unitPrice = null;

    // Prix total de la ligne (quantité x prix unitaire)//
    #[ORM\Column]
    private ?float $totalPrice = null;

    // Plusieurs lignes de commande appartiennent à une commande//
    #[ORM\ManyToOne(inversedBy: 'orderItems')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Order $customerOrder = null;

    // Plusieurs lignes de commande peuvent concerner un produit//
    #[ORM\ManyToOne(inversedBy: 'orderItems')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Product $product = null;

    // Retourne l'identifiant de la ligne//
    public function getId(): ?int
    {
        return $this->id;
    }

    // Retourne la quantité//
    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    // Définit la quantité//
    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    // Retourne le prix unitaire//
    public function getUnitPrice(): ?float
    {
        return $this->unitPrice;
    }

    // Définit le prix unitaire//
    public function setUnitPrice(float $unitPrice): static
    {
        $this->unitPrice = $unitPrice;

        return $this;
    }

    // Retourne le prix total de la ligne//
    public function getTotalPrice(): ?float
    {
        return $this->totalPrice;
    }

    // Définit le prix total//
    public function setTotalPrice(float $totalPrice): static
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    // Retourne la commande liée//
    public function getCustomerOrder(): ?Order
    {
        return $this->customerOrder;
    }

    // Associe la ligne à une commande//
    public function setCustomerOrder(?Order $customerOrder): static
    {
        $this->customerOrder = $customerOrder;

        return $this;
    }

    // Retourne le produit lié//
    public function getProduct(): ?Product
    {
        return $this->product;
    }

    // Associe un produit à la ligne de commande//
    public function setProduct(?Product $product): static
    {
        $this->product = $product;

        return $this;
    }
}
