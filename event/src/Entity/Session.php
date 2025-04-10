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

    #[ORM\Column(type: "datetime")]
    private \DateTimeInterface $logout_time;

    #[ORM\Column(type: "boolean")]
    private bool $is_active;

    public function getId()
    {
        return $this->id;
    }

    public function setId($value)
    {
        $this->id = $value;
    }

    public function getUser_id()
    {
        return $this->user_id;
    }

    public function setUser_id($value)
    {
        $this->user_id = $value;
    }

    public function getLogin_time()
    {
        return $this->login_time;
    }

    public function setLogin_time($value)
    {
        $this->login_time = $value;
    }

    public function getLogout_time()
    {
        return $this->logout_time;
    }

    public function setLogout_time($value)
    {
        $this->logout_time = $value;
    }

    public function getIs_active()
    {
        return $this->is_active;
    }

    public function setIs_active($value)
    {
        $this->is_active = $value;
    }
}
