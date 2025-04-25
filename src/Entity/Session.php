<?php
<<<<<<< HEAD

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

=======
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
>>>>>>> 4dbb084 (code barre eq)
use App\Entity\User;

#[ORM\Entity]
class Session
{
<<<<<<< HEAD

=======
>>>>>>> 4dbb084 (code barre eq)
    #[ORM\Id]
    #[ORM\Column(type: "string", length: 250)]
    private string $id;

<<<<<<< HEAD
        #[ORM\ManyToOne(targetEntity: User::class, inversedBy: "sessions")]
=======
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: "sessions")]
>>>>>>> 4dbb084 (code barre eq)
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private User $user_id;

    #[ORM\Column(type: "datetime")]
    private \DateTimeInterface $login_time;

<<<<<<< HEAD
    #[ORM\Column(type: "datetime")]
    private \DateTimeInterface $logout_time;

    #[ORM\Column(type: "boolean")]
    private bool $is_active;

    public function getId()
=======
    #[ORM\Column(type: "datetime", nullable: true)] // Make logout_time nullable
    private ?\DateTimeInterface $logout_time = null; // Default to null

    #[ORM\Column(type: "boolean")]
    private bool $is_active;
    
    public function __construct(
        string $id,
        User $user,
        \DateTimeInterface $loginTime,
        bool $isActive
    ) {
        $this->id = $id;
        $this->user_id = $user;
        $this->login_time = $loginTime;
        $this->is_active = $isActive;
    }
    
    public function getId(): string
>>>>>>> 4dbb084 (code barre eq)
    {
        return $this->id;
    }

<<<<<<< HEAD
    public function setId($value)
=======
    public function setId(string $value): void
>>>>>>> 4dbb084 (code barre eq)
    {
        $this->id = $value;
    }

<<<<<<< HEAD
    public function getUser_id()
=======
    public function getUser_id(): User
>>>>>>> 4dbb084 (code barre eq)
    {
        return $this->user_id;
    }

<<<<<<< HEAD
    public function setUser_id($value)
=======
    public function setUser_id(User $value): void
>>>>>>> 4dbb084 (code barre eq)
    {
        $this->user_id = $value;
    }

<<<<<<< HEAD
    public function getLogin_time()
=======
    public function getLogin_time(): \DateTimeInterface
>>>>>>> 4dbb084 (code barre eq)
    {
        return $this->login_time;
    }

<<<<<<< HEAD
    public function setLogin_time($value)
=======
    public function setLogin_time(\DateTimeInterface $value): void
>>>>>>> 4dbb084 (code barre eq)
    {
        $this->login_time = $value;
    }

<<<<<<< HEAD
    public function getLogout_time()
=======
    public function getLogout_time(): ?\DateTimeInterface
>>>>>>> 4dbb084 (code barre eq)
    {
        return $this->logout_time;
    }

<<<<<<< HEAD
    public function setLogout_time($value)
=======
    public function setLogout_time(?\DateTimeInterface $value): void
>>>>>>> 4dbb084 (code barre eq)
    {
        $this->logout_time = $value;
    }

<<<<<<< HEAD
    public function getIs_active()
=======
    public function getIs_active(): bool
>>>>>>> 4dbb084 (code barre eq)
    {
        return $this->is_active;
    }

<<<<<<< HEAD
    public function setIs_active($value)
=======
    public function setIs_active(bool $value): void
>>>>>>> 4dbb084 (code barre eq)
    {
        $this->is_active = $value;
    }
}
<<<<<<< HEAD
=======
?>
>>>>>>> 4dbb084 (code barre eq)
