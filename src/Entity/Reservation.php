<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $type_salle = null;

    #[ORM\Column]
    private ?int $nombre_salle = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    private ?User $user = null;

    #[ORM\Column(length: 255 , nullable: true)]
    private ?string $coffee_shop_choisi = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $booking_date = null;

    #[ORM\ManyToOne]
    private ?Forfait $forfait = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeSalle(): ?string
    {
        return $this->type_salle;
    }

    public function setTypeSalle(string $type_salle): static
    {
        $this->type_salle = $type_salle;

        return $this;
    }

    public function getNombreSalle(): ?int
    {
        return $this->nombre_salle;
    }

    public function setNombreSalle(int $nombre_salle): static
    {
        $this->nombre_salle = $nombre_salle;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getCoffeeShopChoisi(): ?string
    {
        return $this->coffee_shop_choisi;
    }

    public function setCoffeeShopChoisi(string $coffee_shop_choisi): static
    {
        $this->coffee_shop_choisi = $coffee_shop_choisi;

        return $this;
    }

    public function getBookingDate(): ?\DateTimeInterface
    {
        return $this->booking_date;
    }

    public function setBookingDate(\DateTimeInterface $booking_date): static
    {
        $this->booking_date = $booking_date;

        return $this;
    }

    public function getForfait(): ?Forfait
    {
        return $this->forfait;
    }

    public function setForfait(?Forfait $forfait): static
    {
        $this->forfait = $forfait;

        return $this;
    }
}
