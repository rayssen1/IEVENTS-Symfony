<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
#[ORM\Table(name: 'equipment')]
class Equipment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: "Le nom ne doit pas être vide.")]
    #[Assert\Regex(
        pattern: "/^[^\d]*$/",
        message: "Le nom ne doit pas contenir de chiffres."
    )]
    private ?string $name = null;

    #[ORM\Column(type: 'string', length: 100)]
    #[Assert\NotBlank(message: "Le type ne doit pas être vide.")]
    private ?string $type = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: "Le statut ne doit pas être vide.")]
    private ?string $status = null;

    #[ORM\Column(type: 'integer')]
    #[Assert\NotNull(message: "La quantité ne doit pas être vide.")]
    #[Assert\LessThan(
        value: 1000,
        message: "La quantité doit être inférieure à 1000."
    )]
    #[Assert\GreaterThan(
        value: 0,
        message: "La quantité doit être supérieure à 0."
    )]
    private ?int $quantity = null;

    #[ORM\Column(type: 'text')]
    #[Assert\NotBlank(message: "La description ne doit pas être vide.")]
    #[Assert\Length(
        max: 30,
        maxMessage: "La description ne doit pas dépasser 30 caractères."
    )]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'equipment', targetEntity: Maintenancerecord::class, cascade: ['remove'])]
    private Collection $maintenancerecords;

    const STATUS_AVAILABLE = 'AVAILABLE';
    const STATUS_RESERVED = 'RESERVED';
    const STATUS_OUT_OF_STOCK = 'OUT OF STOCK';

    public function __construct()
    {
        $this->maintenancerecords = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;
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

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;
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

    public function getMaintenancerecords(): Collection
    {
        return $this->maintenancerecords;
    }

    public function addMaintenancerecord(Maintenancerecord $maintenancerecord): self
    {
        if (!$this->maintenancerecords->contains($maintenancerecord)) {
            $this->maintenancerecords[] = $maintenancerecord;
            $maintenancerecord->setEquipment($this);
        }

        return $this;
    }

    public function removeMaintenancerecord(Maintenancerecord $maintenancerecord): self
    {
        if ($this->maintenancerecords->removeElement($maintenancerecord)) {
            if ($maintenancerecord->getEquipment() === $this) {
                $maintenancerecord->setEquipment(null);
            }
        }

        return $this;
    }

    public function getStatusOptions(): array
    {
        return [
            self::STATUS_AVAILABLE => 'Available',
            self::STATUS_RESERVED => 'Reserved',
            self::STATUS_OUT_OF_STOCK => 'Out of Stock',
        ];
    }
}
