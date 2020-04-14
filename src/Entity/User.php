<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\EqualTo;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
#use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity
 * @UniqueEntity(
 *  fields={"email"},
 *  errorPath="email",
 *  message= "L'Email que vous avez indiqué est déjà utilisé",
 * )
 * @UniqueEntity(
 *  fields={"pseudo"},
 *  errorPath="pseudo",
 *  message="Ce pseudo est déjà utilisé"
 * )
 */
class User implements UserInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="pseudo", type="string", length=30, nullable=false)
     * @NotBlank
     */
    private $pseudo;

    /**
     * @var string
     *
     * @ORM\Column(name="mdp", type="string", length=50, nullable=false)
     * @NotBlank
     */
    private $mdp;
    /**
     * @EqualTo(propertyPath="mdp", message="Votre mot de passe n'est pas le même !")
     */
    public $confirm_mdp;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=65535, nullable=false)
     * @Email()
     * @NotBlank
     */
    private $email;

    public function getId(): ?int
    {
        return $this->id;
    }

    #public function getPseudo(): ?string
    public function getUsername(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    #public function getMdp(): ?string
    public function getPassword(): ?string
    {
        return $this->mdp;
    }

    public function setMdp(string $mdp): self
    {
        $this->mdp = $mdp;

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

    public function eraseCredentials(){}

    public function getSalt(){}

    public function getRoles()
    {
        return ['ROLE_ADMIN'];
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function getMdp(): ?string
    {
        return $this->mdp;
    }

}
