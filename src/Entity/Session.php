<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;

#[ORM\Entity]
class Session
{
    #[ORM\Id]
    #[ORM\Column(type: "string", length: 250)]
    private string $id;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: "sessions")]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private User $user_id;

    #[ORM\Column(type: "datetime")]
    private \DateTimeInterface $login_time;

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
    {
        return $this->id;
    }

    public function setId(string $value): void
    {
        $this->id = $value;
    }

    public function getUser_id(): User
    {
        return $this->user_id;
    }

    public function setUser_id(User $value): void
    {
        $this->user_id = $value;
    }

    public function getLogin_time(): \DateTimeInterface
    {
        return $this->login_time;
    }

    public function setLogin_time(\DateTimeInterface $value): void
    {
        $this->login_time = $value;
    }

    public function getLogout_time(): ?\DateTimeInterface
    {
        return $this->logout_time;
    }

    public function setLogout_time(?\DateTimeInterface $value): void
    {
        $this->logout_time = $value;
    }

    public function getIs_active(): bool
    {
        return $this->is_active;
    }

    public function setIs_active(bool $value): void
    {
        $this->is_active = $value;
    }
}
?>