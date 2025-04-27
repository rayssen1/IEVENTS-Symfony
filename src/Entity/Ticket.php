<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
class Ticket
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\ManyToOne(targetEntity: Reservation::class, inversedBy: "tickets")]
    #[ORM\JoinColumn(name: "reservationId", referencedColumnName: "id", nullable: false)]
    private Reservation $reservationId;

    #[ORM\Column(type: "string", length: 10, name: "ticketType")]
    #[Assert\NotBlank(message: "Le type de billet est requis.")]
    #[Assert\Choice(choices: ["VIP", "BASIC", "KID"], message: "Type de billet invalide.")]
    private string $ticketType;

    #[ORM\Column(type: "integer", name: "ticketCount")]
    #[Assert\NotBlank(message: "Le nombre de billets est requis.")]
    #[Assert\Range(min: 1, max: 10, notInRangeMessage: "Le nombre de billets doit être entre {{ min }} et {{ max }}.")]
    private int $ticketCount;

    #[ORM\Column(type: "float")]
    #[Assert\NotBlank(message: "Le prix est requis.")]
    #[Assert\Positive(message: "Le prix doit être un nombre positif.")]
    private float $price;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getReservationId(): Reservation
    {
        return $this->reservationId;
    }

    public function setReservationId(Reservation $reservation): self
    {
        $this->reservationId = $reservation;
        return $this;
    }

    public function getTicketType(): string
    {
        return $this->ticketType;
    }

    public function setTicketType(string $ticketType): self
    {
        $this->ticketType = $ticketType;
        return $this;
    }

    public function getQrCode(): string
    {
        return $this->qrCode;
    }

    public function setQrCode(string $qrCode): self
    {
        $this->qrCode = $qrCode;
        return $this;
    }

    public function getTicketCount(): int
    {
        return $this->ticketCount;
    }

    public function setTicketCount(int $ticketCount): self
    {
        $this->ticketCount = $ticketCount;
        return $this;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;
        return $this;
    }
}
