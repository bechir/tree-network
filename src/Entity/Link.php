<?php

/*
 * This file is part of the Tree Network application.
 *
 * (c) Bechir Ba <bechiirr71@gmail.com>
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LinkRepository")
 */
class Link
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\LinkCategory")
     * @ORM\JoinColumn(nullable=false)
     */
    private $linkCategory;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="links")
     * @ORM\JoinColumn(nullable=false)
     */
    private $owner;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="inverses", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $inverse;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLinkCategory(): ?LinkCategory
    {
        return $this->linkCategory;
    }

    public function setLinkCategory(?LinkCategory $linkCategory): self
    {
        $this->linkCategory = $linkCategory;

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

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
}
