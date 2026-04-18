<?php

// Entité Product : représente un produit vendu sur le site GreenGoodies//

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

// Lie cette entité à la table product en base de données//
#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    // Identifiant unique du produit//
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    // Nom du produit//
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    // Description courte affichée sur la page catalogue//
    #[ORM\Column(type: Types::TEXT)]
    private ?string $shortDescription = null;

    // Description complète affichée sur la fiche produit//
    #[ORM\Column(type: Types::TEXT)]
    private ?string $fullDescription = null;

    // Prix du produit//
    #[ORM\Column]
    private ?float $price = null;

    // Nom du fichier image du produit//
    #[ORM\Column(length: 255)]
    private ?string $picture = null;

    // Un produit peut être présent dans plusieurs lignes de commande//
    #[ORM\OneToMany(targetEntity: OrderItem::class, mappedBy: 'product')]
    private Collection $orderItems;

    // Initialise la collection des lignes de commande//
    public function __construct()
    {
        $this->orderItems = new ArrayCollection();
    }

    // Retourne l'identifiant du produit//
    public function getId(): ?int
    {
        return $this->id;
    }

    // Retourne le nom du produit//
    public function getName(): ?string
    {
        return $this->name;
    }

    // Définit le nom du produit//
    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    // Retourne la description courte//
    public function getShortDescription(): ?string
    {
        return $this->shortDescription;
    }

    // Définit la description courte//
    public function setShortDescription(string $shortDescription): static
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }

    // Retourne la description complète/
    public function getFullDescription(): ?string
    {
        return $this->fullDescription;
    }

    // Définit la description complète//
    public function setFullDescription(string $fullDescription): static
    {
        $this->fullDescription = $fullDescription;

        return $this;
    }

    // Retourne le prix//
    public function getPrice(): ?float
    {
        return $this->price;
    }

    // Définit le prix//
    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    // Retourne l'image du produit//
    public function getPicture(): ?string
    {
        return $this->picture;
    }

    // Définit l'image du produit//
    public function setPicture(string $picture): static
    {
        $this->picture = $picture;

        return $this;
    }

    // Retourne les lignes de commande liées au produit//
    public function getOrderItems(): Collection
    {
        return $this->orderItems;
    }

    // Ajoute une ligne de commande liée à ce produit//
    public function addOrderItem(OrderItem $orderItem): static
    {
        if (!$this->orderItems->contains($orderItem)) {
            $this->orderItems->add($orderItem);
            $orderItem->setProduct($this);
        }

        return $this;
    }

    // Supprime une ligne de commande liée au produit//
    public function removeOrderItem(OrderItem $orderItem): static
    {
        if ($this->orderItems->removeElement($orderItem)) {
            if ($orderItem->getProduct() === $this) {
                $orderItem->setProduct(null);
            }
        }

        return $this;
    }
}
