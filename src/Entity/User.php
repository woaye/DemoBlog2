<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;


/**
 * 
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @uniqueEntity(
 * fields = ["email"],
 * message= "un compte est déjà existant a cette adresse email
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
     *  message= "cette adresse Email '{{ value}}' n'est pas valide
     * 
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert/Email(
     * message= "cette adresse Email '{{ value}}' n'est pas valide
     * )
     * 
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="8", minMessage="Votre mot de passe doit contnir au minimum 8 caractères")
     * @Assert\EqualTo(propertyPath="confirm_password", message="le mot de passe ne correspond pas")
     * 
     * 
     */
    private $password;

    /**
     *  @Assert\EqualTo(propertyPath="password", message="les mots ne correspondent pas")
     */

    public $confirm_password;


    public function getId(): ?int
    {
        return $this->id;
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

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

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


// cette methode  est destinée à reformaliser les mots de passe
  
{
    public function eraseCredentials()

}


{   
   
    public functiongetSalt()

{
    public functionGetRoles()

{
    return['ROLE_USER'];
}


