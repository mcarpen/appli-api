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
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    private $user_id;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="Restaurant", inversedBy="reviews")
     * @ORM\JoinColumn(name="restaurant_id", referencedColumnName="id", nullable=false)
     */
    private $restaurant_id;

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
    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    /**
     * @param User $user_id
     *
     * @return Review
     */
    public function setUserId(User $user_id): Review
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * @return Restaurant|null
     */
    public function getRestaurantId(): ?Restaurant
    {
        return $this->restaurant_id;
    }

    /**
     * @param Restaurant $restaurant_id
     *
     * @return Review
     */
    public function setRestaurantId(Restaurant $restaurant_id): Review
    {
        $this->restaurant_id = $restaurant_id;

        return $this;
    }
}