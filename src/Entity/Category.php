<?php


namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Category
 *
 * @package App\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="category")
 */
class Category
{

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="User")
     */
    private $users;

    /**
     * @ORM\ManyToMany(targetEntity="Restaurant")
     */
    private $restaurants;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->restaurants = new ArrayCollection();
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
     * @return Category
     */
    public function setName(string $name): Category
    {
        $this->name = $name;

        return $this;
    }
}