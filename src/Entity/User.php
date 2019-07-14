<?php

namespace App\Entity;

use App\Entity\Establishment\BasicInfo;
use App\Entity\Establishment\Immovable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="app_user")
 * @ORM\HasLifecycleCallbacks()
 */
class User extends BaseUser implements EquatableInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, unique=false, nullable=true)
     */
    private $phoneNumber;

    /**
     * @var Avatar
     * 
     * @ORM\OneToOne(targetEntity="App\Entity\Avatar", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $avatar;

    /**
     * @ORM\Column(type="string", length=10, nullable=true, unique=false)
     */
    private $locale;

    const NUM_ITEMS = 15;

    const LC_FR = 'app.locale.fr';
    const LC_EN = 'app.locale.en';
    const LC_AR = 'app.locale.ar';

    const LOCALES = [
        self::LC_AR,
        self::LC_FR,
        self::LC_EN
    ];

    public function __construct()
    {
        parent::__construct();
        $this->setLocale(self::LC_FR);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getLocale(): ?string
    {
        return $this->locale;
    }

    public function setLocale(?string $locale): self
    {
        if(!in_array($locale, self::LOCALES))
            throw new \Exception(sprintf("Unknown locale %s, valid locales are [%s]", $locale, implode(', ', self::LOCALES)));
            
        $this->locale = $locale;

        return $this;
    }

    public function getAvatar()
    {
        return $this->avatar;
    }

    public function setAvatar(?Avatar $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function serialize(): string
    {
        return serialize([
            $this->id,
            $this->username,
            $this->phoneNumber,
            $this->email,
            $this->plainPassword,
            $this->password,
            $this->roles,
            $this->avatar,
            $this->locale
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized): void
    {
        [
            $this->id,
            $this->username,
            $this->phoneNumber,
            $this->email,
            $this->plainPassword,
            $this->password,
            $this->roles,
            $this->avatar,
            $this->locale
        ] = unserialize($serialized);
    }

    public function isEqualTo(UserInterface $user)
    {
        if ($this->password !== $user->getPassword()) {
            return false;
        }
        if ($this->salt !== $user->getSalt()) {
            return false;
        }
        if ($this->username !== $user->getUsername()) {
            return false;
        }
        return true;
    }
}
