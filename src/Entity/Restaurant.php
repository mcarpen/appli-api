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
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=150)
     *
     * @Assert\Length(min=5, max=150)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=50)
     *
     * @Assert\Length(min=1, max=50)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(type="integer", length=6)
     *
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
     * @return null|string
     */
    public function getZip(): ?string
    {
        return $this->zip;
    }

    /**
     * @param string $zip
     *
     * @return Restaurant
     */
    public function setZip(string $zip): Restaurant
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

    public function __toString()
    {
        return $this->getName();
    }
}