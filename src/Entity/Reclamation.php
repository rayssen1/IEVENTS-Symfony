<?php

namespace App\Entity;

<<<<<<< HEAD
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
=======
use App\Repository\ReclamationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReclamationRepository::class)]
#[ORM\Table(name: 'reclamation')]
class Reclamation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'integer', name: 'idUser', nullable: false)]
    private ?int $idUser = null;

    #[ORM\ManyToOne(targetEntity: Evenement::class)]
    #[ORM\JoinColumn(name: 'idEvent', referencedColumnName: 'id', nullable: false)]
    private ?Evenement $evenement = null;

    #[ORM\Column(type: 'string', name: 'subject', nullable: false)]
    private ?string $subject = null;

    #[ORM\Column(type: 'datetime', name: 'dateReclamation', nullable: false)]
    private ?\DateTimeInterface $dateReclamation = null;

    #[ORM\Column(type: 'decimal', name: 'rate', precision: 10, scale: 2, nullable: false)]
    private ?string $rate = null;

    #[ORM\Column(type: 'string', name: 'email', nullable: false)]
    private ?string $email = null;

    #[ORM\OneToMany(targetEntity: Reponse::class, mappedBy: 'reclamation')]
    private Collection $reponses;

    public function __construct()
    {
        $this->reponses = new ArrayCollection();
    }

    public function getId(): ?int
>>>>>>> 4dbb084 (code barre eq)
    {
        return $this->id;
    }

<<<<<<< HEAD
    public function setId($value)
    {
        $this->id = $value;
    }

    public function getIdUser()
=======
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getIdUser(): ?int
>>>>>>> 4dbb084 (code barre eq)
    {
        return $this->idUser;
    }

<<<<<<< HEAD
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
=======
    public function setIdUser(int $idUser): self
    {
        $this->idUser = $idUser;
        return $this;
    }

    public function getEvenement(): ?Evenement
    {
        return $this->evenement;
    }

    public function setEvenement(Evenement $evenement): self
    {
        $this->evenement = $evenement;
        return $this;
    }

    public function getSubject(): ?string
>>>>>>> 4dbb084 (code barre eq)
    {
        return $this->subject;
    }

<<<<<<< HEAD
    public function setSubject($value)
    {
        $this->subject = $value;
    }

    public function getDateReclamation()
=======
    public function setSubject(string $subject): self
    {
        $this->subject = $subject;
        return $this;
    }

    public function getDateReclamation(): ?\DateTimeInterface
>>>>>>> 4dbb084 (code barre eq)
    {
        return $this->dateReclamation;
    }

<<<<<<< HEAD
    public function setDateReclamation($value)
    {
        $this->dateReclamation = $value;
    }

    public function getRate()
=======
    public function setDateReclamation(\DateTimeInterface $dateReclamation): self
    {
        $this->dateReclamation = $dateReclamation;
        return $this;
    }

    public function getRate(): ?string
>>>>>>> 4dbb084 (code barre eq)
    {
        return $this->rate;
    }

<<<<<<< HEAD
    public function setRate($value)
    {
        $this->rate = $value;
    }

    public function getEmail()
=======
    public function setRate(string $rate): self
    {
        $this->rate = $rate;
        return $this;
    }

    public function getEmail(): ?string
>>>>>>> 4dbb084 (code barre eq)
    {
        return $this->email;
    }

<<<<<<< HEAD
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
=======
    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return Collection<int, Reponse>
     */
    public function getReponses(): Collection
    {
        return $this->reponses;
    }

    public function addReponse(Reponse $reponse): self
    {
        if (!$this->reponses->contains($reponse)) {
            $this->reponses[] = $reponse;
            $reponse->setReclamation($this);
        }

        return $this;
    }

    public function removeReponse(Reponse $reponse): self
    {
        if ($this->reponses->removeElement($reponse)) {
            if ($reponse->getReclamation() === $this) {
                $reponse->setReclamation(null);
            }
        }

        return $this;
    }
>>>>>>> 4dbb084 (code barre eq)
}
