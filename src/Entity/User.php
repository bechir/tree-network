<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Constraints as SecurityAssert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="app_user")
 * @ORM\HasLifecycleCallbacks()
 * 
 * @ORM\AttributeOverrides({
 *      @ORM\AttributeOverride(name="email", column=@ORM\Column(nullable=true)),
 *      @ORM\AttributeOverride(name="emailCanonical", column=@ORM\Column(nullable=true, unique=false)),
 *      @ORM\AttributeOverride(name="password", column=@ORM\Column(nullable=true)), 
 *      @ORM\AttributeOverride(name="username",
 *         column=@ORM\Column(
 *             name="username",
 *             type="string",
 *             length=255,
 *             unique=false,
 *             nullable=true
 *         )
 *     ),
 *     @ORM\AttributeOverride(name="usernameCanonical",
 *         column=@ORM\Column(
 *             name="usernameCanonical",
 *             type="string",
 *             length=255,
 *             unique=false,
 *             nullable=true
 *         )
 *     ),
 * })
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
     * @Assert\Date()
     */
    private $bornAt;

    /**
     * @var string
     * 
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $birthPlace;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $submittedAt;

    /**
     * @var Locale
     * 
     * @ORM\ManyToOne(targetEntity="App\Entity\Locale")
     */
    private $locale;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Gender")
     */
    private $gender;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Email()
     */
    private $email2;

    /**
     * @var string
     * //@SecurityAssert\UserPassword()
     */
    private $oldPassword;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Link", mappedBy="owner")
     */
    private $links;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Link", mappedBy="inverse")
     */
    private $inverses;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Image", mappedBy="user", orphanRemoval=true, cascade={"persist", "remove"})
     */
    private $gallery;

    const NB_IMTEMS_HOME = 4;
    CONST NB_IMTEMS_SIMILAR = 7;
    const NB_ITEMS_LISTING = 12;
    const NB_ITEMS_ADMIN_LISTING = 50;

    public function __construct()
    {
        parent::__construct();
        $this->links = new ArrayCollection();
        $this->inverses = new ArrayCollection();
        $this->gallery = new ArrayCollection();
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

    public function getFullName(): string
    {
        return (!empty($this->firstName) || !empty($this->lastName))
            ? $this->lastName . ' ' . $this->firstName
            : $this->username;
    }

    public function getBornAt()
    {
        return $this->bornAt;
    }

    public function setBornAt(\DateTimeInterface $bornAt): self
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

    public function getBirthPlace(): ?string
    {
        return $this->birthPlace;
    }

    public function setBirthPlace(?string $birthPlace): self
    {
        $this->birthPlace = $birthPlace;

        return $this;
    }

    public function getSubmittedAt(): ?\DateTimeInterface
    {
        return $this->submittedAt;
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

    /**
     * @ORM\PrePersist
     */
    public function setSubmittedAt()
    {
        $this->submittedAt = new \DateTime();
    }

    public function getGender(): ?Gender
    {
        return $this->gender;
    }

    public function setGender(?Gender $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getEmail2(): ?string
    {
        return $this->email2;
    }

    public function setEmail2(?string $email2): self
    {
        $this->email2 = $email2;

        return $this;
    }

    public function getOldPassword(): ?string
    {
        return $this->oldPassword;
    }

    public function setOldPassword(?string $oldPassword): self
    {
        $this->oldPassword = $oldPassword;

        return $this;
    }

    /**
     * @return Collection|Link[]
     */
    public function getLinks(): Collection
    {
        return $this->links;
    }

    public function addLink(Link $link): self
    {
        if (!$this->links->contains($link)) {
            $this->links[] = $link;
            $link->setOwner($this);
        }

        return $this;
    }

    public function removeLink(Link $link): self
    {
        if ($this->links->contains($link)) {
            $this->links->removeElement($link);
            // set the owning side to null (unless already changed)
            if ($link->getOwner() === $this) {
                $link->setOwner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Link[]
     */
    public function getInverses(): Collection
    {
        return $this->inverses;
    }

    public function addInverse(Link $inverse): self
    {
        if (!$this->inverses->contains($inverse)) {
            $this->inverses[] = $inverse;
            $inverse->setInverse($this);
        }

        return $this;
    }

    public function removeInverse(Link $inverse): self
    {
        if ($this->inverses->contains($inverse)) {
            $this->inverses->removeElement($inverse);
            // set the owning side to null (unless already changed)
            if ($inverse->getInverse() === $this) {
                $inverse->setInverse(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Image[]
     */
    public function getGallery(): Collection
    {
        return $this->gallery;
    }

    public function addGallery(Image $gallery): self
    {
        if (!$this->gallery->contains($gallery)) {
            $this->gallery[] = $gallery;
            $gallery->setUser($this);
        }

        return $this;
    }

    public function removeGallery(Image $gallery): self
    {
        if ($this->gallery->contains($gallery)) {
            $this->gallery->removeElement($gallery);
            // set the owning side to null (unless already changed)
            if ($gallery->getUser() === $this) {
                $gallery->setUser(null);
            }
        }

        return $this;
    }
}
