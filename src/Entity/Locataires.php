<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
/*use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;*/
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Locataires
 *
 * @ORM\Table(name="locataires")
 * @ORM\Entity
 */
class Locataires
{
    /**
     * @var int
     *
     * @ORM\Column(name="NUMEROLOC", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $numeroloc;

    /**
     * @var string
     *
     * @ORM\Column(name="NOM_LOC", type="string", length=128, nullable=false)
     * @Assert\NotBlank
     */
    private $nomLoc;

    /**
     * @var string
     *
     * @ORM\Column(name="PRENOM_LOC", type="string", length=128, nullable=false)
     * @Assert\NotBlank
     */
    private $prenomLoc;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DATENAISS", type="date", nullable=false)
     * @Assert\NotBlank
     */
    private $datenaiss;

    /**
     * @var string|null
     *
     * @ORM\Column(name="TEL_LOC", type="string", length=255, nullable=true, options={"default"="NULL","fixed"=true})
     * @Assert\Length(min=10, max=10)
     * @Assert\Regex(pattern="#^0[1-9]([-. ]?[0-9]{2}){4}$#")
     * 
     */
    private $telLoc = '';

    /**
     * @var int
     *
     * @ORM\Column(name="R_I_B", type="integer", nullable=false)
     * @Assert\NotBlank
     */
    private $rib;

    /**
     * @var string
     *
     * @ORM\Column(name="BANQUE", type="string", length=128, nullable=false)
     * @Assert\NotBlank
     */
    private $banque;

    /**
     * @var string
     *
     * @ORM\Column(name="RUE_BANQUE", type="string", length=128, nullable=false)
     * @Assert\NotBlank
     */
    private $rueBanque;

    /**
     * @var string
     *
     * @ORM\Column(name="CODEVILLE_BANQUE", type="string", length=128, nullable=false)
     * @Assert\NotBlank
     */
    private $codevilleBanque;

    /**
     * @var string|null
     *
     * @ORM\Column(name="TEL_BANQUE", type="string", length=255, nullable=true, options={"default"="NULL","fixed"=true})
     * @Assert\Length(min=10, max=10)
     * @Assert\Regex(pattern="#^0[1-9]([-. ]?[0-9]{2}){4}$#")
     * 
     */
    private $telBanque = '';

    public function getNumeroloc(): ?int
    {
        return $this->numeroloc;
    }

    public function getNomLoc(): ?string
    {
        return $this->nomLoc;
    }

    public function setNomLoc(string $nomLoc): self
    {
        $this->nomLoc = strtoupper($nomLoc); //écrit le nom en MAJUSCULE

        return $this;
    }

    public function getPrenomLoc(): ?string
    {
        return $this->prenomLoc;
    }

    public function setPrenomLoc(string $prenomLoc): self
    {
        $this->prenomLoc = ucfirst(strtolower($prenomLoc)); //écrit que la première lettre en Majuscule

        return $this;
    }

    public function getNomPrenomLoc(): ?string
    {
        return $this->nomLoc.' '.$this->prenomLoc;
    }

    public function getDatenaiss(): ?\DateTimeInterface
    {
        return $this->datenaiss;
    }

    public function setDatenaiss(\DateTimeInterface $datenaiss): self
    {
        $this->datenaiss = $datenaiss;

        return $this;
    }

    public function getTelLoc(): ?string
    {
        return $this->telLoc;
    }

    public function setTelLoc(?string $telLoc): self
    {
        $this->telLoc = $telLoc;

        return $this;
    }

    public function getRIB(): ?int
    {
        return $this->rib;
    }

    public function setRIB(int $rib): self
    {
        $this->rib = $rib;

        return $this;
    }

    public function getBanque(): ?string
    {
        return $this->banque;
    }

    public function setBanque(string $banque): self
    {
        $this->banque = strtoupper($banque);

        return $this;
    }

    public function getRueBanque(): ?string
    {
        return $this->rueBanque;
    }

    public function setRueBanque(string $rueBanque): self
    {
        $this->rueBanque = $rueBanque;

        return $this;
    }

    public function getCodevilleBanque(): ?string
    {
        return $this->codevilleBanque;
    }

    public function setCodevilleBanque(string $codevilleBanque): self
    {
        $this->codevilleBanque = $codevilleBanque;

        return $this;
    }

    public function getTelBanque(): ?string
    {
        return $this->telBanque;
    }

    public function setTelBanque(?string $telBanque): self
    {
        $this->telBanque = $telBanque;

        return $this;
    }


}
