<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\Collection;
use App\Entity\Evenement;
use App\Repository\EventspeakerRepository;

#[ORM\Entity(repositoryClass: EventspeakerRepository::class)]
class Eventspeaker
{

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 50)]
    private string $nom;

    #[ORM\Column(type: "string", length: 50)]
    private string $prenom;

    #[ORM\Column(type: "text")]
    private string $description;

    #[ORM\Column(type: "string", length: 250)]
    private string $status;

    public function getId()
    {
        return $this->id;
    }

    public function setId($value)
    {
        $this->id = $value;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function setNom($value)
    {
        $this->nom = $value;
    }

    public function getPrenom()
    {
        return $this->prenom;
    }

    public function setPrenom($value)
    {
        $this->prenom = $value;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($value)
    {
        $this->description = $value;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($value)
    {
        $this->status = $value;
    }

    #[ORM\OneToMany(mappedBy: "eventspeakerId", targetEntity: Evenement::class)]
    private Collection $evenements;

        public function getEvenements(): Collection
        {
            return $this->evenements;
        }
    
        public function addEvenement(Evenement $evenement): self
        {
            if (!$this->evenements->contains($evenement)) {
                $this->evenements[] = $evenement;
                $evenement->setEventspeakerId($this);
            }
    
            return $this;
        }
    
        public function removeEvenement(Evenement $evenement): self
        {
            if ($this->evenements->removeElement($evenement)) {
                // set the owning side to null (unless already changed)
                if ($evenement->getEventspeakerId() === $this) {
                    $evenement->setEventspeakerId(null);
                }
            }
    
            return $this;
        }
}
