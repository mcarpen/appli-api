<?php


namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource
 *      attributes={
 *          "normalization_context"={"groups"={"read"}},
 *          "denormalization_context"={"groups"={"write"}}
 *      },
 *      collectionOperations={
 *          "get"={"method"="GET", "access_control"="is_granted('ROLE_USER')"},
 *          "post"={"method"="POST", "access_control"="is_granted('ROLE_ADMIN')"}
 *      },
 *      itemOperations={
 *          "get"={"method"="GET", "access_control"="is_granted('ROLE_USER')"},
 *          "put"={"method"="PUT", "access_control"="is_granted('ROLE_ADMIN')"},
 *          "delete"={"method"="DELETE", "access_control"="is_granted('ROLE_ADMIN')"}
 *      }
 * )
 *
 * @ORM\Entity
 * @ORM\Table(name="category")
 * @UniqueEntity(fields={"name"}, message="Name is already taken")
 */
class Category
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     *
     * @Groups({"read"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     *
     * @Groups({"read", "write"})
     *
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="User", mappedBy="categories")
     * @ApiSubresource()
     */
    private $users;

    /**
     * @ORM\ManyToMany(targetEntity="Restaurant", mappedBy="categories")
     * @ApiSubresource()
     */
    private $restaurants;

    public function __toString()
    {
        return $this->getName();
    }

    public function __construct()
    {
        $this->users       = new ArrayCollection();
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