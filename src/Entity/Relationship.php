<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RelationshipRepository")
 */
class Relationship
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="relationships")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $inverse;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\LinkType")
     * @ORM\JoinColumn(nullable=false)
     */
    private $linkType;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getInverse(): ?User
    {
        return $this->inverse;
    }

    public function setInverse(?User $inverse): self
    {
        $this->inverse = $inverse;

        return $this;
    }

    public function getLinkType(): ?LinkType
    {
        return $this->linkType;
    }

    public function setLinkType(?LinkType $linkType): self
    {
        $this->linkType = $linkType;

        return $this;
    }
}
