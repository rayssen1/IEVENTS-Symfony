<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
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
    private ?string $name = null;

    #[ORM\Column(type: 'string', length: 100)]
    private ?string $type = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $status = null;

    #[ORM\Column(type: 'integer')]
    private ?int $quantity = null;

    #[ORM\Column(type: 'text')]
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

    // Getters and Setters

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
            // Set the owning side to null (unless already changed)
            if ($maintenancerecord->getEquipment() === $this) {
                $maintenancerecord->setEquipment(null);
            }
        }

        return $this;
    }

    // Status options as constants
    public function getStatusOptions(): array
    {
        return [
            self::STATUS_AVAILABLE => 'Available',
            self::STATUS_RESERVED => 'Reserved',
            self::STATUS_OUT_OF_STOCK => 'Out of Stock',
        ];
    }
}
