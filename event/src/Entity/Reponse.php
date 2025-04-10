<?php

namespace App\Entity;

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
    {
        return $this->id;
    }

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
    {
        return $this->message;
    }

    public function setMessage($value)
    {
        $this->message = $value;
    }

    public function getDateRep()
    {
        return $this->dateRep;
    }

    public function setDateRep($value)
    {
        $this->dateRep = $value;
    }

    public function getEtat()
    {
        return $this->etat;
    }

    public function setEtat($value)
    {
        $this->etat = $value;
    }

    public function getMessageRec()
    {
        return $this->messageRec;
    }

    public function setMessageRec($value)
    {
        $this->messageRec = $value;
    }
}
