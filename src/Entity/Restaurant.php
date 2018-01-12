<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource
 *
 * @ORM\Entity
 * @ORM\Table(name="restaurant")
 */
class Restaurant
{
    /**
     * @var int|null
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=50, nullable=false)
     *
     * @Assert\Length(min=1, max=50)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     *
     * @Assert\NotBlank()
     * @Assert\Length(min=50)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=150)
     *
     * @Assert\NotBlank()
     * @Assert\Length(min=5, max=150)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=50)
     *
     * @Assert\NotBlank()
     * @Assert\Length(min=1, max=50)
     */
    private $city;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", length=6)
     *
     * @Assert\NotBlank()
     * @Assert\Length(min=5, max=6)
     */
    private $zip;

    /**
     * @var string
     *
     * @ORM\Column(type="decimal", precision=10, scale=8)
     *
     * @Assert\NotBlank()
     */
    private $lat;

    /**
     * @var string
     *
     * @ORM\Column(type="decimal", precision=11, scale=8)
     *
     * @Assert\NotBlank()
     */
    private $lng;

    /**
     * @var string
     *
     * @ORM\Column(name="phone_number", type="string", length=14)
     *
     * @Assert\NotBlank()
     * @Assert\Length(max="14")
     */
    private $phoneNumber;

    /**
     * @var int
     *
     * @ORM\Column(name="starting_price", type="integer", length=3)
     *
     * @Assert\NotBlank()
     * @Assert\Length(min="1", max="3")
     */
    private $startingPrice;

    /**
     * @var int
     *
     * @ORM\Column(name="ending_price", type="integer", length=3)
     *
     * @Assert\NotBlank()
     * @Assert\Length(min="1", max="3")
     */
    private $endingPrice;

    /**
     * @var array
     *
     * @ORM\Column(type="json_array")
     *
     * @Assert\NotNull()
     */
    private $menu;

    /**
     * @ORM\OneToMany(targetEntity="Review", mappedBy="restaurant")
     */
    private $reviews;

    /**
     * @ORM\ManyToMany(targetEntity="Category", inversedBy="restaurants")
     */
    private $categories;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
    }

    /**
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Restaurant
     */
    public function setName(string $name): Restaurant
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return Restaurant
     */
    public function setDescription(string $description): Restaurant
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
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
     * @return Restaurant
     */
    public function setAddress(string $address): Restaurant
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
     * @return Restaurant
     */
    public function setCity(string $city): Restaurant
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
     * @return Restaurant
     */
    public function setZip(int $zip): Restaurant
    {
        $this->zip = $zip;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getLat(): ?string
    {
        return $this->lat;
    }

    /**
     * @param string $lat
     *
     * @return Restaurant
     */
    public function setLat(string $lat): Restaurant
    {
        $this->lat = $lat;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getLng(): ?string
    {
        return $this->lng;
    }

    /**
     * @param string $lng
     *
     * @return Restaurant
     */
    public function setLng(string $lng): Restaurant
    {
        $this->lng = $lng;

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
     * @return null|string
     */
    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $phoneNumber
     *
     * @return Restaurant
     */
    public function setPhoneNumber(string $phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getStartingPrice(): ?int
    {
        return $this->startingPrice;
    }

    /**
     * @param int $startingPrice
     *
     * @return $this
     */
    public function setStartingPrice(int $startingPrice)
    {
        $this->startingPrice = $startingPrice;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getEndingPrice(): ?int
    {
        return $this->endingPrice;
    }

    /**
     * @param int $endingPrice
     *
     * @return $this
     */
    public function setEndingPrice(int $endingPrice)
    {
        $this->endingPrice = $endingPrice;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getMenu(): ?array
    {
        return $this->menu;
    }

    /**
     * @param array $menu
     *
     * @return $this
     */
    public function setMenu(array $menu)
    {
        $this->menu = $menu;

        return $this;
    }

    public function __toString()
    {
        return $this->getName();
    }
}