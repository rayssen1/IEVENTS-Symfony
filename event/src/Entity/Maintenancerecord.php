<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ORM\Table(name: 'maintenancerecord')]
class Maintenancerecord
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Equipment::class, inversedBy: 'maintenancerecords')]
    #[ORM\JoinColumn(name: 'equipmentid', referencedColumnName: 'id', onDelete: 'CASCADE', nullable: true)]
    #[Assert\NotBlank(message: "L'équipement ne doit pas être vide.")]
    private ?Equipment $equipment = null;

    #[ORM\Column(type: 'datetime')]
    #[Assert\NotBlank(message: "La date ne doit pas être vide.")]
    #[Assert\Type(
        type: \DateTimeInterface::class,
        message: "La date doit être valide."
    )]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(type: 'text')]
    #[Assert\NotBlank(message: "La description ne doit pas être vide.")]
    #[Assert\Length(
        max: 50,
        maxMessage: "La description ne doit pas dépasser {{ limit }} caractères."
    )]
    private ?string $description = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: "Le statut ne doit pas être vide.")]
    #[Assert\Choice(
        choices: ['Operational', 'Needs Repair', 'Out of Service'],
        message: "Le statut doit être l'un des suivants : 'Operational', 'Needs Repair', 'Out of Service'."
    )]
    private ?string $status = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEquipment(): ?Equipment
    {
        return $this->equipment;
    }

    public function setEquipment(?Equipment $equipment): self
    {
        $this->equipment = $equipment;
        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;
        return $this;
    }
}
