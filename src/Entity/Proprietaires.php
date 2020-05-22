<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Proprietaires
 *
 * @ORM\Table(name="proprietaires")
 * @ORM\Entity
 */
class Proprietaires
{
    /**
     * @var int
     *
     * @ORM\Column(name="NUMEROPROP", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $numeroprop;

    /**
     * @var string
     *
     * @ORM\Column(name="NOM", type="string", length=255, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="PRENOM", type="string", length=255, nullable=false)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="ADRESSE", type="string", length=255, nullable=false)
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="CODE_VILLE", type="string", length=128, nullable=false)
     */
    private $codeVille;

    /**
     * @var string|null
     *
     * @ORM\Column(name="TEL", type="string", length=128, nullable=true, options={"default"="NULL"})
     * @Assert\Length(min=10, max=10)
     * @Assert\Regex(pattern="#^0[1-9]([-. ]?[0-9]{2}){4}$#")
     */
    private $tel = '';

    /*private $proprio;*/

    public function getNumeroprop(): ?int
    {
        return $this->numeroprop;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = strtoupper($nom);

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = ucfirst(strtolower($prenom));

        return $this;
    }

    public function getProprio()
    {
        return $this->proprio = $this->getNomPrenom()->getNumeroprop();
    }

    public function getNomPrenom(): ?string
    {
        return $this->nom.' '.$this->prenom;
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

    public function getCodeVille(): ?string
    {
        return $this->codeVille;
    }

    public function setCodeVille(string $codeVille): self
    {
        $this->codeVille = $codeVille;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(?string $tel): self
    {
        $this->tel = $tel;

        return $this;
    }


}
