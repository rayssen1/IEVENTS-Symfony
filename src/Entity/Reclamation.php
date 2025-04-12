<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\Collection;
use App\Entity\Reponse;

#[ORM\Entity]
class Reclamation
{

    #[ORM\Id]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\Column(type: "integer")]
    private int $idUser;

    #[ORM\Column(type: "integer")]
    private int $idEvent;

    #[ORM\Column(type: "string", length: 255)]
    private string $subject;

    #[ORM\Column(type: "datetime")]
    private \DateTimeInterface $dateReclamation;

    #[ORM\Column(type: "float")]
    private float $rate;

    #[ORM\Column(type: "string", length: 500)]
    private string $email;

    public function getId()
    {
        return $this->id;
    }

    public function setId($value)
    {
        $this->id = $value;
    }

    public function getIdUser()
    {
        return $this->idUser;
    }

    public function setIdUser($value)
    {
        $this->idUser = $value;
    }

    public function getIdEvent()
    {
        return $this->idEvent;
    }

    public function setIdEvent($value)
    {
        $this->idEvent = $value;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function setSubject($value)
    {
        $this->subject = $value;
    }

    public function getDateReclamation()
    {
        return $this->dateReclamation;
    }

    public function setDateReclamation($value)
    {
        $this->dateReclamation = $value;
    }

    public function getRate()
    {
        return $this->rate;
    }

    public function setRate($value)
    {
        $this->rate = $value;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($value)
    {
        $this->email = $value;
    }

    #[ORM\OneToMany(mappedBy: "idRec", targetEntity: Reponse::class)]
    private Collection $reponses;

        public function getReponses(): Collection
        {
            return $this->reponses;
        }
    
        public function addReponse(Reponse $reponse): self
        {
            if (!$this->reponses->contains($reponse)) {
                $this->reponses[] = $reponse;
                $reponse->setIdRec($this);
            }
    
            return $this;
        }
    
        public function removeReponse(Reponse $reponse): self
        {
            if ($this->reponses->removeElement($reponse)) {
                // set the owning side to null (unless already changed)
                if ($reponse->getIdRec() === $this) {
                    $reponse->setIdRec(null);
                }
            }
    
            return $this;
        }
}
