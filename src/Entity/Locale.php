<?php

/*
 * This file is part of the Tree Network application.
 *
 * (c) Bechir Ba <bechiirr71@gmail.com>
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LocaleRepository")
 */
class Locale
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    public const FR = 'app.locale.fr';
    public const EN = 'app.locale.en';
    public const AR = 'app.locale.ar';
    public const WLF = 'app.locale.wlf';
    public const PLR = 'app.locale.plr';

    const LOCALES = [
        self::AR,
        self::FR,
        self::EN,
        self::WF,
        self::PL,
    ];

    public function __construct()
    {
        $this->setName(self::FR);
    }

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
        if (!in_array($name, self::LOCALES)) {
            throw new \Exception(sprintf('Unknown locale %s, valid locales are [%s]', $name, implode(', ', self::LOCALES)));
        }
        $this->name = $name;

        return $this;
    }
}
