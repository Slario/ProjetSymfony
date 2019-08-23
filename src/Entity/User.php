<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\OneToMany;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity("username")
 * @UniqueEntity("email")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30, unique=true)
     * @Assert\NotBlank(message="le champ ne peut pas être vide1")
     *
     *
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=40, unique=true)
     * @Assert\NotBlank(message="le champ ne peut pas être vide2")
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=150)
     *
     *
     */
    private $password;

    /**
     * @var string
     */
    private $plainPW;

    /**
     * @ORM\Column(name="roles", type="array")
     * @Assert\NotBlank()
     */
    private $roles;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank()
     */
    private $dateRegistered;

    /**
     * Many Users have Many Favorites.
     * @ManyToMany(targetEntity="Ad", inversedBy="users")
     * @JoinTable(name="users_favorites")
     */
    private $favorites;

    /**
     * One User owns many ads. This is the inverse side.
     * @OneToMany(targetEntity="Ad", mappedBy="owner")
     */
    private $ads;



    public function __construct() {
        $this->dateRegistered = new \DateTime("now");
        $this->roles[] = "ROLE_USER";
        $this->ads = new ArrayCollection();
        $this->favorites = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getFavorites()
    {
        return $this->favorites;
    }

    public function addFavorite(Ad $favorite){
        if (!$this->favorites->contains($favorite)){
            $this->favorites[] = $favorite;
        }
    }

    public function deleteFavorite(Ad $favorite){
        if ($this->favorites->contains($favorite)){
            $this->favorites->removeElement($favorite);
        }
    }




    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string
     */
    public function getPlainPW(): ?string
    {
        return $this->plainPW;
    }

    /**
     * @param string $plainPW
     */
    public function setPlainPW(string $plainPW): self
    {
        $this->plainPW = $plainPW;

        return $this;
    }



    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }


    public function getDateRegistered(): ?\DateTimeInterface
    {
        return $this->dateRegistered;
    }

    public function setDateRegistered(\DateTimeInterface $dateRegistered): self
    {
        $this->dateRegistered = $dateRegistered;

        return $this;
    }

    /**
     * Returns the roles granted to the user.
     *
     *     public function getRoles()
     *     {
     *         return ['ROLE_USER'];
     *     }
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        //$this->password = null;
    }

    /**
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string The password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->username;
    }


}
