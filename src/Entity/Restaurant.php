<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Restaurant
 *
 * @package App\Entity
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
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=30)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=5)
     */
    private $zip;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $lat;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $lng;

    /**
     * @ORM\OneToMany(targetEntity="Review", mappedBy="restaurant_id")
     */
    private $reviews;

    public function __toString()
    {
        return $this->getName();
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
     * @return null|string
     */
    public function getReviews(): ?string
    {
        return $this->reviews;
    }
}