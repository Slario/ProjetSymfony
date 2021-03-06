<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\ManyToOne;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AdRepository")
 */
class Ad
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=40, unique=true)
     * @Assert\NotBlank()
     *
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=400)
     * @Assert\NotBlank()
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=40)
     * @Assert\NotBlank()
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=5)
     * @Assert\NotBlank()
     */
    private $zip;



    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     */
    private $price;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank()
     */
    private $dateCreated;

    /**
     * Many Ads have one Category. This is the owning side.
     * @ManyToOne(targetEntity="Category", inversedBy="ads")
     * @JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;



    /**
     * Many Ads are in the favorites of Many Users.
     * @ManyToMany(targetEntity="User", mappedBy="favorites")
     */
    private $users;

    /**
     * One Owner may have Many Ads. This is the owning side.
     * @ManyToOne(targetEntity="User", inversedBy="ads")
     * @JoinColumn(name="owner_id", referencedColumnName="id")
     */
    private $owner;

    public function __construct() {
        $this->users = new ArrayCollection();
        $this->dateCreated = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }


    public function getCategory()
    {
        return $this->category;
    }


    public function setCategory($category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getZip(): ?string
    {
        return $this->zip;
    }

    public function setZip(string $zip): self
    {
        $this->zip = $zip;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->dateCreated;
    }

    public function setDateCreated(\DateTimeInterface $dateCreated): self
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param mixed $users
     */
    public function setUsers($users): self
    {
        $this->users = $users;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param mixed $owner
     */
    public function setOwner($owner): self
    {
        $this->owner = $owner;

        return $this;
    }
}
