<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(
 *  fields= {"userName"}),
 *  message= "Ce nom d'utilisateur est déjà utilisé !"
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="2", minMessage="Votre pseudo doit contenir au minimum 2 caractères")
     * @Assert\Length(max="255", maxMessage="Votre mot de passe doit faire au maximum 255 caractères")
     */
    private $userName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="8", minMessage="Votre mot de passe doit faire au minimum 8 caractères")
     * @Assert\Length(max="255", maxMessage="Votre mot de passe doit faire au maximum 255 caractères")
     */
    private $password;

    /**
     * @Assert\EqualTo(propertyPath="password", message="Les 2 mots de passe sont différents.")
     */
    public $confirm_password;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserName(): ?string
    {
        return $this->userName;
    }

    public function setUserName(string $userName): self
    {
        $this->userName = $userName;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    // Méthodes de l'interface (l'interface nous oblige à écrire toutes ses méthodes)
    public function getRoles() 
    {
        return ['ROLE_USER'];
    }
    public function getSalt() {}
    public function eraseCredentials() {}
}
