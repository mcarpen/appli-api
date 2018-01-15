<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *      attributes={
 *          "normalization_context"={"groups"={"read"}},
 *          "denormalization_context"={"groups"={"write"}}
 *      },
 *      collectionOperations={
 *          "get"={"method"="GET", "access_control"="is_granted('ROLE_ADMIN')"},
 *          "post"={"method"="POST", "access_control"="is_granted('IS_AUTHENTICATED_ANONYMOUSLY')"}
 *      },
 *      itemOperations={
 *          "get"={"method"="GET", "access_control"="(is_granted('ROLE_USER') and object.getId() == user.getId()) or is_granted('ROLE_ADMIN')"},
 *          "put"={"method"="PUT", "access_control"="(is_granted('ROLE_USER') and object.getId() == user.getId()) or is_granted('ROLE_ADMIN')"},
 *          "delete"={"method"="DELETE", "access_control"="is_granted('ROLE_ADMIN')"}
 *      }
 * )
 *
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\EntityListeners({"App\Listener\Entity\UserListener"})
 * @ORM\Table(name="app_user")
 * @UniqueEntity(fields={"email"}, message="Email already taken")
 */
class User implements AdvancedUserInterface, \Serializable
{
    /**
     * @var int|null
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @Groups({"read"})
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=60, unique=true)
     *
     * @Groups({"read", "write"})
     *
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=128)
     */
    private $password;

    /**
     * @var array
     *
     * @ORM\Column(type="json_array")
     *
     * @Groups({"read"})
     *
     * @Assert\NotNull()
     */
    private $roles;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     *
     * @Groups({"read"})
     */
    private $active;

    /**
     * @var string|null
     * @link https://symfony.com/blog/cve-2013-5750-security-issue-in-fosuserbundle-login-form
     *
     * @Assert\NotBlank()
     * @Assert\Length(max=4096)
     *
     * @Groups({"write"})
     *
     * Used by a listener to encode password when a user is created/updated with a plainPassword attribute not null.
     * Not Persisted!!
     */
    private $plainPassword;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=30)
     *
     * @Groups({"read", "write"})
     *
     * @Assert\NotBlank()
     * @Assert\Length(max="30")
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=30)
     *
     * @Groups({"read", "write"})
     *
     * @Assert\NotBlank()
     * @Assert\Length(max=30)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=100)
     *
     * @Groups({"read", "write"})
     *
     * @Assert\NotBlank()
     * @Assert\Length(max=100)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=30)
     *
     * @Groups({"read", "write"})
     *
     * @Assert\NotBlank()
     * @Assert\Length(max=30)
     */
    private $city;

    /**
     * @var int
     *
     * @ORM\Column(name="zip", type="integer", length=6)
     *
     * @Groups({"read", "write"})
     *
     * @Assert\NotBlank()
     * @Assert\Length(min=5, max=6)
     */
    private $zip;

    /**
     * @var string
     *
     * @ORM\Column(name="phone_number", type="string", length=14)
     *
     * @Groups({"read", "write"})
     *
     * @Assert\NotBlank()
     * @Assert\Length(max="14")
     */
    private $phoneNumber;

    /**
     * @var bool
     *
     * @Groups({"write"})
     */
    private $isRestaurant;

    /**
     * @ORM\OneToMany(targetEntity="Review", mappedBy="user")
     * @ApiSubresource()
     */
    private $reviews;

    /**
     * @ORM\ManyToMany(targetEntity="Category", inversedBy="users")
     * @ApiSubresource()
     */
    private $categories;

    const ROLE_DEFAULT = 'ROLE_USER';
    const ROLE_CUSTOMER = 'ROLE_CUSTOMER';
    const ROLE_RESTAURANT = 'ROLE_RESTAURANT';
    const ROLE_ADMIN = 'ROLE_ADMIN';
    const ROLE_SUPER_ADMIN = 'ROLE_SUPER_ADMIN';


    public function __construct()
    {
        $this->active     = true;
        $this->roles      = [self::ROLE_DEFAULT];
        $this->categories = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getUsername(): ?string
    {
        return $this->email;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return User
     */
    public function setEmail(string $email): User
    {
        $this->email = $email;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string $password
     *
     * @return User
     */
    public function setPassword(string $password): User
    {
        $this->password = $password;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getRoles(): array
    {
        $roles = $this->roles;

        return array_unique($this->roles);
    }

    /**
     * @param string $role
     *
     * @return bool
     */
    public function hasRole(string $role)
    {
        return in_array(mb_strtoupper($role), $this->getRoles(), true);
    }

    /**
     * @param string $role
     *
     * @return User
     */
    public function removeRole(string $role): User
    {
        if (false !== $key = array_search(mb_strtoupper($role), $this->roles, true)) {
            unset($this->roles[$key]);
            $this->roles = array_values($this->roles);
        }

        return $this;
    }

    /**
     * @param array $roles
     *
     * @return User
     */
    public function setRoles(array $roles): User
    {
        $this->roles = array_map(
            function ($role) {
                return mb_strtoupper($role);
            },
            array_unique($roles)
        );

        return $this;
    }

    /**
     * @param string $role
     *
     * @return User
     */
    public function addRole(string $role): User
    {
        $role = mb_strtoupper($role);

        if ( ! in_array($role, $this->roles, true)) {
            $this->roles[] = $role;
        }

        return $this;
    }

    /**
     * @see User::getActive()
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @return bool
     */
    public function getActive(): bool
    {
        return $this->active;
    }

    /**
     * @param bool $active
     *
     * @return User
     */
    public function setActive(bool $active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    /**
     * @param string $plainPassword
     *
     * @return User
     */
    public function setPlainPassword(string $plainPassword)
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     *
     * @return $this
     */
    public function setFirstName(string $firstName): User
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     *
     * @return $this
     */
    public function setLastName(string $lastName): User
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @param string $address
     *
     * @return $this
     */
    public function setAddress(string $address): User
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param string $city
     *
     * @return $this
     */
    public function setCity(string $city): User
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getZip(): ?int
    {
        return $this->zip;
    }

    /**
     * @param int $zip
     *
     * @return $this
     */
    public function setZip(int $zip): User
    {
        $this->zip = $zip;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $phoneNumber
     *
     * @return $this
     */
    public function setPhoneNumber(string $phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * @return ArrayCollection|Review[]
     */
    public function getReviews()
    {
        return $this->reviews;
    }

    /**
     * @return ArrayCollection|Category[]
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param Category $category
     */
    public function setCategory(Category $category)
    {
        if ($this->categories->contains($category)) {
            return;
        }

        $this->categories[] = $category;
    }

    /**
     * @return bool
     */
    public function isRestaurant(): ?bool
    {
        return $this->isRestaurant;
    }

    /**
     * @param bool $isRestaurant
     *
     * @return User
     */
    public function setIsRestaurant(bool $isRestaurant)
    {
        $this->isRestaurant = $isRestaurant;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isAccountNonExpired(): bool
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isAccountNonLocked(): bool
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isCredentialsNonExpired(): bool
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isEnabled(): bool
    {
        return $this->active;
    }

    /**
     * {@inheritdoc}
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function eraseCredentials(): void
    {
        $this->plainPassword = null;
    }

    /**
     * {@inheritdoc}
     */
    public function serialize(): ?string
    {
        return serialize([
            $this->id,
            $this->email,
            $this->password,
            $this->active,
            $this->firstName,
            $this->lastName,
            $this->address,
            $this->city,
            $this->zip,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized): void
    {
        list (
            $this->id,
            $this->email,
            $this->password,
            $this->active,
            $this->firstName,
            $this->lastName,
            $this->address,
            $this->city,
            $this->zip
            )
            = unserialize($serialized);
    }

    public function __toString()
    {
        return $this->getEmail();
    }
}