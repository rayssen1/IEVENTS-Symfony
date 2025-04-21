<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use App\Entity\Eventspeaker;
use App\Entity\User;
use App\Entity\Reclamation;
use App\Repository\EvenementRepository;

#[ORM\Entity(repositoryClass: EvenementRepository::class)]
class Evenement
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 100)]
    #[Assert\NotBlank(message: 'Le titre est requis.')]
    #[Assert\Length(max: 100, maxMessage: 'Le titre ne peut pas dépasser 100 caractères.')]
    private string $titre;

    #[ORM\Column(type: "text")]
    #[Assert\NotBlank(message: 'La description est requise.')]
    private string $description;

    #[ORM\Column(name: "dateEvent", type: "date")]  
    #[Assert\NotBlank(message: 'La date de l\'événement est requise.')]
    private \DateTimeInterface $dateEvent;

    #[ORM\Column(type: "string", length: 100)]
    #[Assert\NotBlank(message: 'Le lieu est requis.')]
    #[Assert\Length(max: 10, maxMessage: 'Le lieu ne peut pas dépasser 10 caractères.')]
    private string $lieu;

    #[ORM\Column(name: "nbPlace",type: "integer")]
    #[Assert\NotBlank(message: 'Le nombre de places est requis.')]
    #[Assert\GreaterThanOrEqual(value: 0, message: 'Le nombre de places doit être positif ou zéro.')]
    private int $nbPlace;

    #[ORM\Column(type: "float")]
    #[Assert\NotBlank(message: 'Le prix est requis.')]
    #[Assert\GreaterThanOrEqual(value: 0, message: 'Le prix doit être positif ou zéro.')]
    private float $prix;

    #[ORM\Column(type: "string", length: 250)]
    private string $status;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: "evenements")]
    #[ORM\JoinColumn(name: 'organisateurId', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private User $organisateurId;

    #[ORM\ManyToOne(targetEntity: Eventspeaker::class, inversedBy: "evenements")]
    #[ORM\JoinColumn(name: 'eventspeakerId', referencedColumnName: 'id', onDelete: 'CASCADE')]
    #[Assert\NotNull(message: 'Un orateur est requis pour l\'événement.')]
    private Eventspeaker $eventspeakerId;

    #[ORM\Column(type: "string", length: 255)]
    private string $img;

    #[ORM\OneToMany(mappedBy: 'evenement', targetEntity: Reclamation::class)]
    private Collection $reclamations; // added

    public function __construct()
    {
        $this->reclamations = new ArrayCollection(); // added
        $this->dateEvent = new \DateTime();
    }

    #[Assert\Callback]
    public function validateDateEvent(ExecutionContextInterface $context): void
    {
        $now = new \DateTime('now');
        $minDate = (clone $now)->modify('+24 hours');

        if ($this->dateEvent < $minDate) {
            $context->buildViolation('La date de l\'événement doit être au moins 24 heures après maintenant.')
                ->atPath('dateEvent')
                ->addViolation();
        }
    }

    #[Assert\Callback]
    public function validateTitre(ExecutionContextInterface $context): void
    {
        if (!empty($this->titre) && $this->titre[0] !== strtoupper($this->titre[0])) {
            $context->buildViolation('Le premier caractère du titre doit être en majuscule.')
                ->atPath('titre')
                ->addViolation();
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitre()
    {
        return $this->titre;
    }

    public function setTitre($value): void
    {
        $this->titre = ($value); 
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($value)
    {
        $this->description = $value;
    }

    public function getDateEvent(): \DateTimeInterface
    {
        return $this->dateEvent;
    }

    public function setDateEvent(\DateTimeInterface $value): self
    {
        $this->dateEvent = $value;
        return $this;
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

    /**
     * @return Collection<int, Reclamation>
     */
    public function getReclamations(): Collection
    {
        return $this->reclamations; // added
    }

    public function addReclamation(Reclamation $reclamation): self
    {
        if (!$this->reclamations->contains($reclamation)) {
            $this->reclamations[] = $reclamation;
            $reclamation->setEvenement($this);
        }
        return $this; // added
    }

    public function removeReclamation(Reclamation $reclamation): self
    {
        if ($this->reclamations->removeElement($reclamation)) {
            if ($reclamation->getEvenement() === $this) {
                $reclamation->setEvenement(null);
            }
        }
        return $this; // added
    }
}
