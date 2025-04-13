<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use App\Entity\Reservation;

#[ORM\Entity]
class Payment
{

    #[ORM\Id]
    #[ORM\Column(type: "integer")]
    private int $id;

        #[ORM\ManyToOne(targetEntity: Reservation::class, inversedBy: "payments")]
    #[ORM\JoinColumn(name: 'reservationId', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private Reservation $reservationId;

    #[ORM\Column(type: "float")]
    private float $amount;

    #[ORM\Column(type: "datetime")]
    private \DateTimeInterface $paymentDate;

    #[ORM\Column(type: "string")]
    private string $status;

    #[ORM\Column(type: "string")]
    private string $paymentType;

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

    public function getAmount()
    {
        return $this->amount;
    }

    public function setAmount($value)
    {
        $this->amount = $value;
    }

    public function getPaymentDate()
    {
        return $this->paymentDate;
    }

    public function setPaymentDate($value)
    {
        $this->paymentDate = $value;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($value)
    {
        $this->status = $value;
    }

    public function getPaymentType()
    {
        return $this->paymentType;
    }

    public function setPaymentType($value)
    {
        $this->paymentType = $value;
    }
}
