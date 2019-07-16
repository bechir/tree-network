<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LinkTypeRepository")
 */
class LinkType
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\LinkName")
     * @ORM\JoinColumn(nullable=false)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\LinkName")
     * @ORM\JoinColumn(nullable=false)
     */
    private $inverse;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?LinkName
    {
        return $this->name;
    }

    public function setName(?LinkName $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getInverse(): ?LinkName
    {
        return $this->inverse;
    }

    public function setInverse(?LinkName $inverse): self
    {
        $this->inverse = $inverse;

        return $this;
    }
}
