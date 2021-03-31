<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PostRepository::class)
 */
class Post
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $id_utl;

    /**
     * @ORM\Column(type="datetime")
     */
    private $datepost;

    /**
     * @ORM\Column(type="string", length=5000)
     */
    private $message;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $solution;

    /**
     * @ORM\OneToMany(targetEntity=Reaction::class, mappedBy="Post")
     */
    private $reactions;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titres;

    public function __construct()
    {
        $this->reactions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUtl(): ?string
    {
        return $this->id_utl;
    }

    public function setIdUtl(string $id_utl): self
    {
        $this->id_utl = $id_utl;

        return $this;
    }

    public function getDatepost(): ?\DateTimeInterface
    {
        return $this->datepost;
    }

    public function setDatepost(\DateTimeInterface $datepost): self
    {
        $this->datepost = $datepost;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getsolution(): ?int
    {
        return $this->solution;
    }

    public function setsolution(int $solution): self
    {
        $this->solution = $solution;

        return $this;
    }

    /**
     * @return Collection|Reaction[]
     */
    public function getReactions(): Collection
    {
        return $this->reactions;
    }

    public function addReaction(Reaction $reaction): self
    {
        if (!$this->reactions->contains($reaction)) {
            $this->reactions[] = $reaction;
            $reaction->setPost($this);
        }

        return $this;
    }

    public function removeReaction(Reaction $reaction): self
    {
        if ($this->reactions->removeElement($reaction)) {
            // set the owning side to null (unless already changed)
            if ($reaction->getPost() === $this) {
                $reaction->setPost(null);
            }
        }

        return $this;
    }

    public function getTitres(): ?string
    {
        return $this->titres;
    }

    public function setTitres(string $titres): self
    {
        $this->titres = $titres;

        return $this;
    }
}
