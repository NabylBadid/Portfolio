<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ProjectRepository::class)
 */
class Project
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=5, max=255,
     * minMessage="Votre message doit contenir au minimum 5 caractères",
     * maxMessage="Votre message doit contenir au maximum 255 caractères"
     * )
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(min=10,
     * minMessage="Votre message doit contenir au minimum 5 caractères",
     * )
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $image;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity=ProjectLike::class, mappedBy="project")
     */
    private $likes;

    public function __construct()
    {
        $this->likes = new ArrayCollection();
    }

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Url()
     */
    // private $urlSite;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    // public function getUrlSite(): ?string
    // {
    //     return $this->urlSite;
    // }

    // public function setUrlSite(string $urlSite): self
    // {
    //     $this->urlSite = $urlSite;

    //     return $this;
    // }


    /**
     * @return Collection|ProjectLike[]
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(ProjectLike $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes[] = $like;
            $like->setProject($this);
        }

        return $this;
    }

    public function removeLike(ProjectLike $like): self
    {
        if ($this->likes->contains($like)) {
            $this->likes->removeElement($like);
            // set the owning side to null (unless already changed)
            if ($like->getProject() === $this) {
                $like->setProject(null);
            }
        }

        return $this;
    }

    /**
     * Permet de savoir si le projet est liké par l'utilisateur
     */
    public function isLikedByUser(User $user): bool 
    {
        foreach ($this->likes as $like) {
            if ($like->getUser() === $user) return true;
        }

        return false;
    }
}
