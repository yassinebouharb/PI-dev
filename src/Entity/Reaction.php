<?php

namespace App\Entity;

use App\Repository\ReactionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReactionRepository::class)
 */
class Reaction
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Post::class, inversedBy="reactions")
     * @ORM\JoinColumn(nullable=True)
     */
    private $post;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $id_utli;

    /**
     * @ORM\Column(type="string", length=5000)
     */
    private $message;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPost(): ?post
    {
        return $this->post;
    }

    public function setPost(?post $post): self
    {
        $this->post = $post;

        return $this;
    }

    public function getIdUtli(): ?string
    {
        return $this->id_utli;
    }

    public function setIdUtli(string $id_utli): self
    {
        $this->id_utli = $id_utli;

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
}
