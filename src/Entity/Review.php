<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Review
 *
 * @package App\Entity
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
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="json_array", nullable=true)
     */
    private $content;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="reviews")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @var int
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
     * @return null|string
     */
    public function getContent(): ?string
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