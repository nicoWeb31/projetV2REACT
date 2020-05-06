<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(
 * fields = {"username"},
 * message="le pseudo existe déjà")
 * @Vich\Uploadable
 */


 //The problem is, when User Entity was implementing the UserInterface,
 // the user provider(actually the Doctrine, behind the scene) tried to Serializing the User object to store it in the session but because of the file that I assigned it to this class, it fails it's career!
 //https://stackoverflow.com/questions/49782167/serialization-of-symfony-component-httpfoundation-file-file-is-not-allowed-sy


class User implements UserInterface,\Serializable
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
     * @ORM\Column(type="string", length=255 )
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
     * 
     * @Vich\UploadableField(mapping="images_users", fileNameProperty="photo")
     */
    private $imageFile;

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

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $activationToken;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $resetToken;

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

    public function setPhoto(?string $photo): self  ///important doit pouvoir etre null
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


    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function setImageFile(?File $imageFile = null): self
    {
        $this->imageFile = $imageFile;
        return $this;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updated_at = new \DateTimeImmutable();
        }
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getActivationToken(): ?string
    {
        return $this->activationToken;
    }

    public function setActivationToken(?string $activationToken): self
    {
        $this->activationToken = $activationToken;

        return $this;
    }

    public function getResetToken(): ?string
    {
        return $this->resetToken;
    }

    public function setResetToken(?string $resetToken): self
    {
        $this->resetToken = $resetToken;

        return $this;
    }

    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->mail,
            $this->password,
            $this->name,
            $this->prenom,
            $this->activationToken,
            $this->username,
            $this->photo,
            //$this->imageFile
        ));
    }

    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->mail,
            $this->password,
            $this->name,
            $this->prenom,
            $this->activationToken,
            $this->username,
            $this->photo,
            //$this->imageFile
        ) = unserialize($serialized, array('allowed_classes' => false));
    }


}
