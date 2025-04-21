<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\Collection;
use App\Entity\Evenement;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;


#[ORM\Entity]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "AUTO")] // or "IDENTITY"
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 50)]
    #[Assert\NotBlank(message: "Nom is required")]
    #[Assert\Regex(
        pattern: "/^[^\d]+$/",
        message: "Nom should not contain digits"
    )]
    private ?string $nom ;

    #[ORM\Column(type: "string", length: 50)]
    #[Assert\NotBlank(message: "Prenom is required")]
    #[Assert\Regex(
        pattern: "/^[^\d]+$/",
        message: "Prenom should not contain digits"
    )]
    private ?string $prenom ;

    #[ORM\Column(type: "string", length: 100)]
    #[Assert\NotBlank(message: "Email is required")]
    #[Assert\Email(message: "Enter a valid email address")]
    private ?string $email ;

    #[ORM\Column(type: "string", length: 255)]
    #[Assert\NotBlank(message: "Password is required")]
    #[Assert\Regex(
        pattern: "/^(?=.*[A-Z])(?=.*\d).{8,}$/",
        message: "Password must be at least 8 characters, contain an uppercase letter and a digit"
    )]
    private ?string $password ;

    #[ORM\Column(type: "string", length: 50)]
    #[Assert\NotBlank(message: "Role is required")]
    private ?string $role ;

    #[ORM\Column( name:'phoneNumber', type: "string", length: 255,nullable:true)]
    #[Assert\NotBlank(message: "Phone number is required")]
    private ?string $phoneNumber ='' ;
    #[ORM\Column(type: "string", length: 250)]
    private ?string $state= 'active' ;
    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }

    public function getPrenom(): string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;
        return $this;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;
        return $this;
    }
    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(?string $state): self
    {
        $this->state = $state;
        return $this;
    }

    // Optional: If you're using salt, you can implement getSalt()
    public function getSalt(): ?string
    {
        return null; // BCrypt doesn't require salt explicitly
    }

    // Implement other methods required by UserInterface
    public function getRoles(): array
    {
        return ['ROLE_USER']; // Adjust depending on your user roles
    }

    public function getUserIdentifier(): string
    {
        return $this->email; // Or however your user is identified (e.g., email)
    }


    public function eraseCredentials(): void
    {
        // Clean up any sensitive data if needed
    }
    #[ORM\OneToMany(mappedBy: "userId", targetEntity: Reservation::class)]
    private Collection $reservations;

        public function getReservations(): Collection
        {
            return $this->reservations;
        }
    
        public function addReservation(Reservation $reservation): self
        {
            if (!$this->reservations->contains($reservation)) {
                $this->reservations[] = $reservation;
                $reservation->setUserId($this);
            }
    
            return $this;
        }
    
        public function removeReservation(Reservation $reservation): self
        {
            if ($this->reservations->removeElement($reservation)) {
                // set the owning side to null (unless already changed)
                if ($reservation->getUserId() === $this) {
                    $reservation->setUserId(null);
                }
            }
    
            return $this;
        }

    #[ORM\OneToMany(mappedBy: "user_id", targetEntity: Session::class)]
    private Collection $sessions;

        public function getSessions(): Collection
        {
            return $this->sessions;
        }
    
        public function addSession(Session $session): self
        {
            if (!$this->sessions->contains($session)) {
                $this->sessions[] = $session;
                $session->setUser_id($this);
            }
    
            return $this;
        }
    
        public function removeSession(Session $session): self
        {
            if ($this->sessions->removeElement($session)) {
                // set the owning side to null (unless already changed)
                if ($session->getUser_id() === $this) {
                    $session->setUser_id(null);
                }
            }
    
            return $this;
        }

    #[ORM\OneToMany(mappedBy: "organisateurId", targetEntity: Evenement::class)]
    private Collection $evenements;

        public function getEvenements(): Collection
        {
            return $this->evenements;
        }
    
        public function addEvenement(Evenement $evenement): self
        {
            if (!$this->evenements->contains($evenement)) {
                $this->evenements[] = $evenement;
                $evenement->setOrganisateurId($this);
            }
    
            return $this;
        }
    
        public function removeEvenement(Evenement $evenement): self
        {
            if ($this->evenements->removeElement($evenement)) {
                // set the owning side to null (unless already changed)
                if ($evenement->getOrganisateurId() === $this) {
                    $evenement->setOrganisateurId(null);
                }
            }
    
            return $this;
        }
}
