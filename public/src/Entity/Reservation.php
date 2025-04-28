<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

use App\Entity\User;
use App\Entity\Payment;
use App\Entity\Ticket;

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
    private float $totalPrice;

    #[ORM\Column(type: "string", length: 255)]
    #[Assert\NotBlank(message: "Le statut est requis.")]
    #[Assert\Choice(choices: ["en attente", "confirmee", "annulee"], message: "Statut invalide.")]
    private string $status;

    #[ORM\Column(type: "datetime", name: "createdAt")]
    private \DateTimeInterface $createdAt;

    #[ORM\OneToMany(mappedBy: "reservationId", targetEntity: Payment::class)]
    private Collection $payments;

    #[ORM\OneToMany(mappedBy: "reservationId", targetEntity: Ticket::class, cascade: ["persist"])]
    private Collection $tickets;

    public function __construct()
    {
        $this->payments = new ArrayCollection();
        $this->tickets = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Ticket>
     */
    public function getTickets(): Collection
    {
        return $this->tickets;
    }

    public function addTicket(Ticket $ticket): self
    {
        if (!$this->tickets->contains($ticket)) {
            $this->tickets->add($ticket);
            $ticket->setReservationId($this);
        }
        return $this;
    }

    public function removeTicket(Ticket $ticket): self
    {
        if ($this->tickets->removeElement($ticket)) {
            if ($ticket->getReservationId() === $this) {
                $ticket->setReservationId(null);
            }
        }
        return $this;
    }
}
