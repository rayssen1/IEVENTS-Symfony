<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity]
class Ticket
{

    #[ORM\Id]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\Column(type: "integer")]
    private int $reservationId;

    #[ORM\Column(type: "string")]
    private string $ticketType;

    #[ORM\Column(type: "string", length: 255)]
    private string $qrCode;

    #[ORM\Column(type: "integer")]
    private int $TicketCount;

    #[ORM\Column(type: "float")]
    private float $price;

    public function getId()
    {
        return $this->id;
    }

    public function setId($value)
    {
        $this->id = $value;
    }

    public function getReservationId()
    {
        return $this->reservationId;
    }

    public function setReservationId($value)
    {
        $this->reservationId = $value;
    }

    public function getTicketType()
    {
        return $this->ticketType;
    }

    public function setTicketType($value)
    {
        $this->ticketType = $value;
    }

    public function getQrCode()
    {
        return $this->qrCode;
    }

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
    {
        return $this->price;
    }

    public function setPrice($value)
    {
        $this->price = $value;
    }
}
