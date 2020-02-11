<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AstreRepository")
 */
class Astre
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $perihelion;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $mass;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $volume;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $discoveryDate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPerihelion(): ?int
    {
        return $this->perihelion;
    }

    public function setPerihelion(?int $perihelion): self
    {
        $this->perihelion = $perihelion;

        return $this;
    }

    public function getMass(): ?float
    {
        return $this->mass;
    }

    public function setMass(?float $mass): self
    {
        $this->mass = $mass;

        return $this;
    }

    public function getVolume(): ?float
    {
        return $this->volume;
    }

    public function setVolume(?float $volume): self
    {
        $this->volume = $volume;

        return $this;
    }

    public function getDiscoveryDate(): ?\DateTimeInterface
    {
        return $this->discoveryDate;
    }

    public function setDiscoveryDate(?\DateTimeInterface $discoveryDate): self
    {
        $this->discoveryDate = $discoveryDate;

        return $this;
    }
}
