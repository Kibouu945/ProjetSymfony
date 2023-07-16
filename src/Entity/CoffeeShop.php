<?php

namespace App\Entity;

use App\Repository\CoffeeShopRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CoffeeShopRepository::class)]
class CoffeeShop
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column]
    private ?int $nombre_place_salle_prive_dispo = null;

    #[ORM\Column]
    private ?int $nombre_place_indiv = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getNombrePlaceSallePriveDispo(): ?int
    {
        return $this->nombre_place_salle_prive_dispo;
    }

    public function setNombrePlaceSallePriveDispo(int $nombre_place_salle_prive_dispo): static
    {
        $this->nombre_place_salle_prive_dispo = $nombre_place_salle_prive_dispo;

        return $this;
    }

    public function getNombrePlaceIndiv(): ?int
    {
        return $this->nombre_place_indiv;
    }

    public function setNombrePlaceIndiv(int $nombre_place_indiv): static
    {
        $this->nombre_place_indiv = $nombre_place_indiv;

        return $this;
    }
}
