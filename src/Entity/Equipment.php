<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\Collection;
use App\Entity\Maintenance_record;

#[ORM\Entity]
class Equipment
{

    #[ORM\Id]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\Column(type: "string", length: 255)]
    private string $name;

    #[ORM\Column(type: "string", length: 100)]
    private string $type;

    #[ORM\Column(type: "string")]
    private string $status;

    #[ORM\Column(type: "integer")]
    private int $quantity;

    #[ORM\Column(type: "text")]
    private string $description;

    public function getId()
    {
        return $this->id;
    }

    public function setId($value)
    {
        $this->id = $value;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($value)
    {
        $this->name = $value;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($value)
    {
        $this->type = $value;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($value)
    {
        $this->status = $value;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function setQuantity($value)
    {
        $this->quantity = $value;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($value)
    {
        $this->description = $value;
    }

    #[ORM\OneToMany(mappedBy: "equipmentId", targetEntity: Maintenance_record::class)]
    private Collection $maintenance_records;

        public function getMaintenance_records(): Collection
        {
            return $this->maintenance_records;
        }
    
        public function addMaintenance_record(Maintenance_record $maintenance_record): self
        {
            if (!$this->maintenance_records->contains($maintenance_record)) {
                $this->maintenance_records[] = $maintenance_record;
                $maintenance_record->setEquipmentId($this);
            }
    
            return $this;
        }
    
        public function removeMaintenance_record(Maintenance_record $maintenance_record): self
        {
            if ($this->maintenance_records->removeElement($maintenance_record)) {
                // set the owning side to null (unless already changed)
                if ($maintenance_record->getEquipmentId() === $this) {
                    $maintenance_record->setEquipmentId(null);
                }
            }
    
            return $this;
        }
}
