<?php

namespace App\Entity;

use App\Repository\ListeamisRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ListeamisRepository::class)
 */
class Listeamis
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
     * @ORM\Column(type="string", length=255)
     */
    private $idami;

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

    public function getIdami(): ?string
    {
        return $this->idami;
    }

    public function setIdami(string $idami): self
    {
        $this->idami = $idami;

        return $this;
    }
}
