<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
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
     * @var integer
     * 
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @var string
     * 
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
     * @var string
     * 
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $firstName;

    /**
     * @var string
     * 
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lastName;

    /**
     * @var \Date
     * @ORM\Column(type="date", nullable=true)
     */
    private $bornAt;

    /**
     * @var string
     * 
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var BirthPlace
     * @ORM\ManyToOne(targetEntity="App\Entity\BirthPlace")
     */
    private $birthPlace;

    /**
     * @var Locale
     * 
     * @ORM\ManyToOne(targetEntity="App\Entity\Locale")
     */
    private $locale;

    const NUM_ITEMS = 15;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Return the user's id
     * 
     * @return integer|null
     */
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

    public function getAvatar()
    {
        return $this->avatar;
    }

    public function setAvatar(?Avatar $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getBornAt()
    {
        return $this->bornAt;
    }

    public function setBornAt($bornAt): self
    {
        $this->bornAt = $bornAt;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getBirthPlace(): ?BirthPlace
    {
        return $this->birthPlace;
    }

    public function setBirthPlace(?BirthPlace $birthPlace): self
    {
        $this->birthPlace = $birthPlace;

        return $this;
    }

    public function getLocale()
    {
        return $this->locale;
    }

    public function setLocale(?Locale $locale): self
    {
        $this->locale = $locale;

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
            $this->firstName,
            $this->lastName,
            $this->description,
            $this->bornAt,
            $this->birthPlace,
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
            $this->firstName,
            $this->lastName,
            $this->description,
            $this->bornAt,
            $this->birthPlace,
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
