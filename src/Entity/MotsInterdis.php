<?php

namespace App\Entity;

use App\Repository\MotsInterdisRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MotsInterdisRepository::class)
 */
class MotsInterdis
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
    private $mots;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMots(): ?string
    {
        return $this->mots;
    }

    public function setMots(string $mots): self
    {
        $this->mots = $mots;

        return $this;
    }
}
