<?php

namespace App\Entity;

use App\Repository\MessengerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MessengerRepository::class)
 */
class Messenger
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $id_exp;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $id_recp;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $message;

    /**
     * @ORM\Column(type="datetime")
     */
    private $datee;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdExp(): ?string
    {
        return $this->id_exp;
    }

    public function setIdExp(string $id_exp): self
    {
        $this->id_exp = $id_exp;

        return $this;
    }

    public function getIdRecp(): ?string
    {
        return $this->id_recp;
    }

    public function setIdRecp(string $id_recp): self
    {
        $this->id_recp = $id_recp;

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

    public function getDatee(): ?\DateTimeInterface
    {
        return $this->datee;
    }

    public function setDatee(\DateTimeInterface $datee): self
    {
        $this->datee = $datee;

        return $this;
    }
}
