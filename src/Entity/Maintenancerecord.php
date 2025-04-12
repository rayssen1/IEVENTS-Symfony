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
    #[Assert\NotBlank(message: "Equipment should not be blank.")]
    private ?Equipment $equipment = null;

    #[ORM\Column(type: 'datetime')]
    #[Assert\NotBlank(message: "Date should not be blank.")]
    #[Assert\Type(
        type: "\DateTimeInterface",
        message: "Date must be a valid date."
    )]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(type: 'text')]
    #[Assert\NotBlank(message: "Description should not be blank.")]
    #[Assert\Length(
        max: 30,
        maxMessage: "Description cannot be longer than {{ limit }} characters."
    )]
    private ?string $description = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: "Status should not be blank.")]
    #[Assert\Type(
        type: "string",
        message: "Status should be a valid string."
    )]
    #[Assert\Regex(
        pattern: '/\D/',  // \D matches any non-digit character
        message: 'Status should not contain any digits.'
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
