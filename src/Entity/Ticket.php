<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
<<<<<<< HEAD

=======
use Symfony\Component\Validator\Constraints as Assert;
>>>>>>> 4dbb084 (code barre eq)

#[ORM\Entity]
class Ticket
{
<<<<<<< HEAD

    #[ORM\Id]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\Column(type: "integer")]
    private int $reservationId;

    #[ORM\Column(type: "string", length: 255)]
    private string $ticketType;

    #[ORM\Column(type: "string", length: 255)]
    private string $qrCode;

    #[ORM\Column(type: "integer")]
    private int $TicketCount;

    #[ORM\Column(type: "float")]
    private float $price;

    public function getId()
=======
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
>>>>>>> 4dbb084 (code barre eq)
    {
        return $this->id;
    }

<<<<<<< HEAD
    public function setId($value)
    {
        $this->id = $value;
    }

    public function getReservationId()
=======
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getReservationId(): Reservation
>>>>>>> 4dbb084 (code barre eq)
    {
        return $this->reservationId;
    }

<<<<<<< HEAD
    public function setReservationId($value)
    {
        $this->reservationId = $value;
    }

    public function getTicketType()
=======
    public function setReservationId(Reservation $reservation): self
    {
        $this->reservationId = $reservation;
        return $this;
    }

    public function getTicketType(): string
>>>>>>> 4dbb084 (code barre eq)
    {
        return $this->ticketType;
    }

<<<<<<< HEAD
    public function setTicketType($value)
    {
        $this->ticketType = $value;
    }

    public function getQrCode()
=======
    public function setTicketType(string $ticketType): self
    {
        $this->ticketType = $ticketType;
        return $this;
    }

    public function getQrCode(): string
>>>>>>> 4dbb084 (code barre eq)
    {
        return $this->qrCode;
    }

<<<<<<< HEAD
    public function setQrCode($value)
    {
        $this->qrCode = $value;
    }

    public function getTicketCount()
    {
        return $this->TicketCount;
    }

    public function setTicketCount($value)
    {
        $this->TicketCount = $value;
    }

    public function getPrice()
=======
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
>>>>>>> 4dbb084 (code barre eq)
    {
        return $this->price;
    }

<<<<<<< HEAD
    public function setPrice($value)
    {
        $this->price = $value;
=======
    public function setPrice(float $price): self
    {
        $this->price = $price;
        return $this;
>>>>>>> 4dbb084 (code barre eq)
    }
}
