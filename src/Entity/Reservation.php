<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\Column(length: 255)]
    private ?string $booking_date = null;

    #[ORM\Column]
    private ?int $duration_time = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getBookingDate(): ?string
    {
        return $this->booking_date;
    }

    public function setBookingDate(string $booking_date): static
    {
        $this->booking_date = $booking_date;

        return $this;
    }

    public function getDurationTime(): ?int
    {
        return $this->duration_time;
    }

    public function setDurationTime(int $duration_time): static
    {
        $this->duration_time = $duration_time;

        return $this;
    }
}
