<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use App\Entity\User;
use Doctrine\Common\Collections\Collection;
use App\Entity\Payment;

#[ORM\Entity]
class Reservation
{

    #[ORM\Id]
    #[ORM\Column(type: "integer")]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: "reservations")]
    #[ORM\JoinColumn(name: 'userId', referencedColumnName: 'id', onDelete: 'CASCADE', nullable: false)]
    private User $userId;

    #[ORM\ManyToOne(targetEntity: Evenement::class)]
    #[ORM\JoinColumn(name: "eventId", referencedColumnName: "id", onDelete: "CASCADE", nullable: false)]
    private Evenement $evenement;
    
    

    #[ORM\Column(type: "float", name: "totalPrice")]
    #[Assert\NotBlank(message: "Le prix est requis.")]
    #[Assert\Positive(message: "Le prix doit être un nombre positif.")]
    private float $totalPrice;

    #[ORM\Column(type: "string", length: 255)]
    #[Assert\NotBlank(message: "Le statut est requis.")]
    #[Assert\Choice(choices: ["en attente", "confirmée", "annulée"], message: "Statut invalide.")]
    private string $status;

    #[ORM\Column(type: "datetime", name: "createdAt")]
    private \DateTimeInterface $createdAt;

    public function getId()
    {
        return $this->id;
    }

    public function setId($value)
    {
        $this->id = $value;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function setUserId($value)
    {
        $this->userId = $value;
    }

    public function getEvenement(): Evenement
    {
        return $this->evenement;
    }
    
    public function setEvenement(Evenement $evenement): self
    {
        $this->evenement = $evenement;
        return $this;
    }

    public function getEventId()
    {
        return $this->eventId;
    }

    public function setEventId($value)
    {
        $this->eventId = $value;
    }

    public function getTotalPrice()
    {
        return $this->totalPrice;
    }

    public function setTotalPrice($value)
    {
        $this->totalPrice = $value;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($value)
    {
        $this->status = $value;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt($value)
    {
        $this->createdAt = $value;
    }

    #[ORM\OneToMany(mappedBy: "reservationId", targetEntity: Payment::class)]
    private Collection $payments;
}
