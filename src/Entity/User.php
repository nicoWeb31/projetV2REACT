<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(
 * fields = {"username"},
 * message="le pseudo existe déjà")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     * @ORM\Column(type="integer")
     */
    private $codePostal;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotCompromisedPassword(message ="mots de passe trop faible")
     */
    private $password;

    /**
     * 
     * @Assert\EqualTo(propertyPath="password",message =" les mots de passe ne corespondent pas !!! ")
     */
    private $verifPassword;


    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email(message = "Cette adresse mail '{{ value }}' n'est pas valide.")
     * 
     */
    private $mail;

    /**
     * @ORM\Column(type="integer")
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photo;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="user", orphanRemoval=true)
     */
    private $commentaires;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $roles;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\CatergoryUser", inversedBy="users")
     */
    private $catergoryUsers;

    public function __construct()
    {
        $this->commentaires = new ArrayCollection();
        $this->catergoryUsers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCodePostal(): ?int
    {
        return $this->codePostal;
    }

    public function setCodePostal(int $codePostal): self
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getPhone(): ?int
    {
        return $this->phone;
    }

    public function setPhone(int $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Comment $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->setUser($this);
        }

        return $this;
    }

    public function removeCommentaire(Comment $commentaire): self
    {
        if ($this->commentaires->contains($commentaire)) {
            $this->commentaires->removeElement($commentaire);
            // set the owning side to null (unless already changed)
            if ($commentaire->getUser() === $this) {
                $commentaire->setUser(null);
            }
        }

        return $this;
    }

    public function getRoles(): ?array
    {
        return [$this->roles];
    }

    public function setRoles(string $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @return Collection|CatergoryUser[]
     */
    public function getCatergoryUsers(): Collection
    {
        return $this->catergoryUsers;
    }

    public function addCatergoryUser(CatergoryUser $catergoryUser): self
    {
        if (!$this->catergoryUsers->contains($catergoryUser)) {
            $this->catergoryUsers[] = $catergoryUser;
            $catergoryUser->addUser($this);
        }

        return $this;
    }

    public function removeCatergoryUser(CatergoryUser $catergoryUser): self
    {
        if ($this->catergoryUsers->contains($catergoryUser)) {
            $this->catergoryUsers->removeElement($catergoryUser);
            $catergoryUser->removeUser($this);
        }

        return $this;
    }

    /**
     * Get the value of verifPassword
     */ 
    public function getVerifPassword()
    {
        return $this->verifPassword;
    }

    /**
     * Set the value of verifPassword
     *
     * @return  self
     */ 
    public function setVerifPassword($verifPassword)
    {
        $this->verifPassword = $verifPassword;

        return $this;
    }


    // =========================================================================
    // security yaml methode implement 
    // =========================================================================
    public function eraseCredentials()
    {

    }
    public function getSalt()
    {

    }

}
