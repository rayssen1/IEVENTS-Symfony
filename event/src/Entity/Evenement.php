<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use App\Entity\Eventspeaker;

#[ORM\Entity(repositoryClass: EvenementRepository::class)]
class Evenement
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id;

    #[ORM\Column(type: "string", length: 100)]
    private string $titre;

    #[ORM\Column(type: "text")]
    private string $description;

    #[ORM\Column(name: "dateEvent", type: "date")]  // <-- Ajoutez name="dateEvent"
    private \DateTimeInterface $dateEvent;

    #[ORM\Column(type: "string", length: 100)]
    private string $lieu;

    #[ORM\Column(name: "nbPlace",type: "integer")]
    private int $nbPlace;

    #[ORM\Column(type: "float")]
    private float $prix;

    #[ORM\Column(type: "string", length: 250)]
    private string $status;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: "evenements")]
    #[ORM\JoinColumn(name: 'organisateurId', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private User $organisateurId;
//    private int $organisateurId = 1;

        #[ORM\ManyToOne(targetEntity: Eventspeaker::class, inversedBy: "evenements")]
    #[ORM\JoinColumn(name: 'eventspeakerId', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private Eventspeaker $eventspeakerId;

    #[ORM\Column(type: "string", length: 255)]
    private string $img;

    public function getId()
    {
        return $this->id;
    }

    public function getTitre()
    {
        return $this->titre;
    }

    public function setTitre($value)
    {
        $this->titre = $value;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($value)
    {
        $this->description = $value;
    }

    public function getDateEvent()
    {
        return $this->dateEvent;
    }

    public function setDateEvent($value)
    {
        $this->dateEvent = $value;
    }

    public function getLieu()
    {
        return $this->lieu;
    }

    public function setLieu($value)
    {
        $this->lieu = $value;
    }

    public function getNbPlace()
    {
        return $this->nbPlace;
    }

    public function setNbPlace($value)
    {
        $this->nbPlace = $value;
    }

    public function getPrix()
    {
        return $this->prix;
    }

    public function setPrix($value)
    {
        $this->prix = $value;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($value)
    {
        $this->status = $value;
    }

    public function getOrganisateurId()
    {
        return $this->organisateurId;
    }

    public function setOrganisateurId($value)
    {
        $this->organisateurId = $value;
    }

    public function getEventspeakerId()
    {
        return $this->eventspeakerId;
    }

    public function setEventspeakerId($value)
    {
        $this->eventspeakerId = $value;
    }

    public function getImg()
    {
        return $this->img;
    }

    public function setImg($value)
    {
        $this->img = $value;
    }
}
