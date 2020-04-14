<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints\EqualTo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Clients
 *
 * @ORM\Table(name="clients")
 * @ORM\Entity
 * @UniqueEntity(
 *  fields={"pseudo"},
 *  errorPath="pseudo",
 *  message="Ce pseudo est déjà utilisé"
 * )
 */
class Clients implements UserInterface/*, \Serializable*/
{
    /**
     * @var int
     *
     * @ORM\Column(name="NUM_CLI", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $numCli;

    /**
     * @var string
     *
     * @ORM\Column(name="NOM_CLI", type="string", length=128, nullable=false)
     */
    private $nomCli;

    /**
     * @var string
     *
     * @ORM\Column(name="PRENOM_CLI", type="string", length=128, nullable=false)
     */
    private $prenomCli;

    /**
     * @var string
     *
     * @ORM\Column(name="ADRESSE_CLI", type="string", length=255, nullable=false)
     */
    private $adresseCli;

    /**
     * @var string
     *
     * @ORM\Column(name="CODEVILLE_CLI", type="string", length=128, nullable=false)
     */
    private $codevilleCli;

    /**
     * @var string|null
     *
     * @ORM\Column(name="TEL_CLI", type="string", length=128, nullable=true, options={"default"="NULL"})
     * @Assert\Length(min=10, max=10)
     * @Assert\Regex(pattern="#^0[1-9]([-. ]?[0-9]{2}){4}$#")
     * 
     */
    private $telCli = '';

    /**
     * @var string
     *
     * @ORM\Column(name="pseudo", type="string", length=100, nullable=false)
     * @Assert\NotBlank
     */
    private $pseudo;

    /**
     * @var string
     *
     * @ORM\Column(name="mdp", type="string", length=100, nullable=false)
     * @Assert\NotBlank
     */
    private $mdp;

    /**
     * @EqualTo(propertyPath="mdp", message="Votre mot de passe n'est pas le même !")
     */
    public $confirm_mdp;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Appartements", inversedBy="numCli")
     * @ORM\JoinTable(name="visiter",
     *   joinColumns={
     *     @ORM\JoinColumn(name="NUM_CLI", referencedColumnName="NUM_CLI")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="NUMAPPART", referencedColumnName="NUMAPPART")
     *   }
     * )
     */
    private $numappart;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->numappart = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getNumCli(): ?int
    {
        return $this->numCli;
    }

    public function getNomCli(): ?string
    {
        return $this->nomCli;
    }

    public function setNomCli(string $nomCli): self
    {
        $this->nomCli = strtoupper($nomCli); //écrit le nom en MAJUSCULE

        return $this;
    }

    public function getPrenomCli(): ?string
    {
        return $this->prenomCli;
    }

    public function setPrenomCli(string $prenomCli): self
    {
        $this->prenomCli = ucfirst(strtolower($prenomCli)); //écrit que la première lettre en Majuscule

        return $this;
    }

    public function getAdresseCli(): ?string
    {
        return $this->adresseCli;
    }

    public function setAdresseCli(string $adresseCli): self
    {
        $this->adresseCli = $adresseCli;

        return $this;
    }

    public function getCodevilleCli(): ?string
    {
        return $this->codevilleCli;
    }

    public function setCodevilleCli(string $codevilleCli): self
    {
        $this->codevilleCli = $codevilleCli;

        return $this;
    }

    public function getTelCli(): ?string
    {
        return $this->telCli;
    }

    public function setTelCli(?string $telCli): self
    {
        $this->telCli = $telCli;

        return $this;
    }

    public function getNomPrenomCli(): ?string
    {
        return $this->nomCli.' '.$this->prenomCli;
    }

    /**
     * @return Collection|Appartements[]
     */
    public function getNumappart(): Collection
    {
        return $this->numappart;
    }

    public function addNumappart(Appartements $numappart): self
    {
        if (!$this->numappart->contains($numappart)) {
            $this->numappart[] = $numappart;
        }

        return $this;
    }

    public function removeNumappart(Appartements $numappart): self
    {
        if ($this->numappart->contains($numappart)) {
            $this->numappart->removeElement($numappart);
        }

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->pseudo;
    }

    public function setUsername(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->mdp;
    }

    public function setPassword(string $mdp): self
    {
        $this->mdp = $mdp;

        return $this;
    }

    public function eraseCredentials(){}

    public function getSalt(){}

    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getMdp(): ?string
    {
        return $this->mdp;
    }

    public function setMdp(string $mdp): self
    {
        $this->mdp = $mdp;

        return $this;
    }

}
