<?php

namespace App\Entity;

<<<<<<< HEAD
use Doctrine\ORM\Mapping as ORM;

use App\Entity\Reclamation;

#[ORM\Entity]
class Reponse
{

    #[ORM\Id]
    #[ORM\Column(type: "integer")]
    private int $id;

        #[ORM\ManyToOne(targetEntity: Reclamation::class, inversedBy: "reponses")]
    #[ORM\JoinColumn(name: 'idRec', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private Reclamation $idRec;

    #[ORM\Column(type: "text")]
    private string $message;

    #[ORM\Column(type: "datetime")]
    private \DateTimeInterface $dateRep;

    #[ORM\Column(type: "string", length: 255)]
    private string $etat;

    #[ORM\Column(type: "string", length: 500)]
    private string $messageRec;

    public function getId()
=======
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use App\Repository\ReponseRepository;

#[ORM\Entity(repositoryClass: ReponseRepository::class)]
#[ORM\Table(name: 'reponse')]
class Reponse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

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

    public function getIdRec()
    {
        return $this->idRec;
    }

    public function setIdRec($value)
    {
        $this->idRec = $value;
    }

    public function getMessage()
=======
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    #[ORM\ManyToOne(targetEntity: Reclamation::class, inversedBy: 'reponses')]
    #[ORM\JoinColumn(name: 'idRec', referencedColumnName: 'id')]
    private ?Reclamation $reclamation = null;

    public function getReclamation(): ?Reclamation
    {
        return $this->reclamation;
    }

    public function setReclamation(?Reclamation $reclamation): self
    {
        $this->reclamation = $reclamation;
        return $this;
    }

    #[ORM\Column(type: 'text',name: 'message', nullable: false)]
    private ?string $message = null;

    public function getMessage(): ?string
>>>>>>> 4dbb084 (code barre eq)
    {
        return $this->message;
    }

<<<<<<< HEAD
    public function setMessage($value)
    {
        $this->message = $value;
    }

    public function getDateRep()
=======
    public function setMessage(string $message): self
    {
        $this->message = $message;
        return $this;
    }

    #[ORM\Column(type: 'datetime', name: 'dateRep', nullable: true)]
    private ?\DateTimeInterface $dateRep = null;

    public function getDateRep(): ?\DateTimeInterface
>>>>>>> 4dbb084 (code barre eq)
    {
        return $this->dateRep;
    }

<<<<<<< HEAD
    public function setDateRep($value)
    {
        $this->dateRep = $value;
    }

    public function getEtat()
=======
    public function setDateRep(?\DateTimeInterface $dateRep): self
    {
        $this->dateRep = $dateRep;
        return $this;
    }

    #[ORM\Column(type: 'string',name: 'etat', nullable: false)]
    private ?string $etat = null;

    public function getEtat(): ?string
>>>>>>> 4dbb084 (code barre eq)
    {
        return $this->etat;
    }

<<<<<<< HEAD
    public function setEtat($value)
    {
        $this->etat = $value;
    }

    public function getMessageRec()
=======
    public function setEtat(string $etat): self
    {
        $this->etat = $etat;
        return $this;
    }

    #[ORM\Column(type: 'string',name: 'messageRec', nullable: false)]
    private ?string $messageRec = null;

    public function getMessageRec(): ?string
>>>>>>> 4dbb084 (code barre eq)
    {
        return $this->messageRec;
    }

<<<<<<< HEAD
    public function setMessageRec($value)
    {
        $this->messageRec = $value;
    }
=======
    public function setMessageRec(string $messageRec): self
    {
        $this->messageRec = $messageRec;
        return $this;
    }

>>>>>>> 4dbb084 (code barre eq)
}
