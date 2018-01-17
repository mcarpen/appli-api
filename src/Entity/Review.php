<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource
 *
 * @ORM\Entity
 * @ORM\Table(name="review")
 */
class Review
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=50)
     *
     * @Assert\Length(min="5", max="50")
     */
    private $name;

    /**
     * @var array
     *
     * @ORM\Column(type="json_array", nullable=true)
     */
    private $content;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="reviews")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @var Restaurant
     *
     * @ORM\ManyToOne(targetEntity="Restaurant", inversedBy="reviews")
     * @ORM\JoinColumn(nullable=false)
     */
    private $restaurant;

    public function __toString()
    {
        return $this->getName();
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
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Review
     */
    public function setName(string $name): Review
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return null|array
     */
    public function getContent(): ?array
    {
        return $this->content;
    }

    /**
     * @param $content
     *
     * @return Review
     */
    public function setContent($content): Review
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return User|null
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     *
     * @return Review
     */
    public function setUser(User $user): Review
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Restaurant|null
     */
    public function getRestaurant()
    {
        return $this->restaurant;
    }

    /**
     * @param Restaurant $restaurant
     *
     * @return Review
     */
    public function setRestaurant(Restaurant $restaurant): Review
    {
        $this->restaurant = $restaurant;

        return $this;
    }
}