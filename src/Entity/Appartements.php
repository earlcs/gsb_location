<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints\Type;

/**
 * Appartements
 *
 * @ORM\Table(name="appartements", indexes={@ORM\Index(name="I_FK_APPARTEMENTS_PROPRIETAIRES", columns={"NUMEROPROP"}), @ORM\Index(name="I_FK_APPARTEMENTS_LOCATAIRES", columns={"NUMEROLOC"})})
 * @ORM\Entity
 * 
 */
class Appartements
{
    /**
     * @var int
     *
     * @ORM\Column(name="NUMAPPART", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $numappart;

    /**
     * @var \Typeappart
     *
     * @ORM\ManyToOne(targetEntity="Typeappart")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="TYPAPPART", referencedColumnName="TYPE_APPART")
     * })
     */
    private $typappart;

    /**
     * @var string
     *
     * @ORM\Column(name="TYPAPPART", type="string", length=128, nullable=false)
     */
    private $typeappart;

     /**
     * @var string
     *
     * @ORM\Column(name="PRIX_LOC", type="decimal", precision=10, scale=0, nullable=false)
     */
    private $prixLoc;

    /**
     * @var string
     *
     * @ORM\Column(name="PRIX_CHARG", type="decimal", precision=10, scale=0, nullable=false)
     */
    private $prixCharg;

    /**
     * @var string
     *
     * @ORM\Column(name="RUE", type="string", length=255, nullable=false)
     */
    private $rue;

    /**
     * 
     *
     * @ORM\ManyToOne(targetEntity="Arrondissement")
     * 
     * @ORM\JoinColumn(name="ARRONDISSEMENT", referencedColumnName="ARRONDISS_DEM")
     * 
     * 
     */
    private $arrondissement;

    /**
     * 
     * @ORM\Column(name="ARRONDISSEMENT", type="integer", nullable=false)
     */
    private $arrondissappart;

    /**
     * @var int
     *
     * @ORM\Column(name="ETAGE", type="integer", nullable=true, options={"default"="NULL"})
     */
    private $etage;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="ASCENSEUR", type="boolean", nullable=true, options={"default"="1"})
     */
    private $ascenseur = true;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="PREAVIS", type="boolean", nullable=true)
     */
    private $preavis = '0';

    /**
     * @var \Date
     * @ORM\Column(name="DATE_LIBRE", type="date", nullable=false)
     * 
     */
    private $dateLibre;

    /**
     * 
     * @ORM\ManyToOne(targetEntity="Proprietaires")
     * 
     * @ORM\JoinColumn(name="NUMEROPROP", referencedColumnName="NUMEROPROP")
     * 
     */
    private $numeroprop;

    /**
     * @ORM\Column(name="NUMEROPROP", type="integer", nullable=false)
     */
    private $proprietaire;

    /**
     * 
     * @ORM\ManyToOne(targetEntity="Locataires")
     * @ORM\JoinColumn(name="NUMEROLOC", referencedColumnName="NUMEROLOC")
     * 
     */
    private $numeroloc;

    /**
     * @ORM\Column(name="NUMEROLOC", type="integer", nullable=false)
     */
    private $locataire;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Clients", mappedBy="numappart")
     */
    private $numCli;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->numCli = new ArrayCollection();
    }

    public function getNumappart(): ?int
    {
        return $this->numappart;
    }

    public function getTypeappart(): ?string
    {
        return $this->typeappart;
    }

    public function setTypeappart(string $typeappart): self
    {
        $this->typeappart = $typeappart;

        return $this;
    }


    public function getPrixLoc(): ?string
    {
        return $this->prixLoc;
    }

    public function setPrixLoc(?string $prixLoc): self
    {
        $this->prixLoc = $prixLoc;

        return $this;
    }

    public function getPrixCharg(): ?string
    {
        return $this->prixCharg;
    }

    public function setPrixCharg(?string $prixCharg): self
    {
        $this->prixCharg = $prixCharg;

        return $this;
    }

    public function getRue(): ?string
    {
        return $this->rue;
    }

    public function setRue(string $rue): self
    {
        $this->rue = $rue;

        return $this;
    }

    public function getArrondissappart(): ?int
    {
        return $this->arrondissappart;
    }

    public function setArrondissappart(int $arrondissappart): self
    {
        $this->arrondissappart = $arrondissappart;

        return $this;
    }

    /*public function getArrondissappart(): ?Arrondissement
    {
        return $this->arrondissappart;
    }

    public function setArrondissappart(Arrondissement $arrondissappart): self
    {
        $this->arrondissappart = $arrondissappart;

        return $this;
    }*/

    public function getArrondissement(): ?Arrondissement
    {
        return $this->arrondissement;
    }


    public function setArrondissement(Arrondissement $arrondissement): self
    {
        $this->arrondissement = $arrondissement;

        return $this;
    }

    public function getEtage(): ?int
    {
        return $this->etage;
    }

    public function setEtage(?int $etage): self
    {
        $this->etage = $etage;

        return $this;
    }

    public function getAscenseur(): ?bool
    {
        return $this->ascenseur;
    }

    public function setAscenseur(?bool $ascenseur): self
    {
        $this->ascenseur = $ascenseur;

        return $this;
    }

    public function getPreavis(): ?bool
    {
        return $this->preavis;
    }

    public function setPreavis(?bool $preavis): self
    {
        $this->preavis = $preavis;

        return $this;
    }

    public function getDateLibre(): ?\DateTimeInterface
    {
        return $this->dateLibre;
    }

    public function setDateLibre(\DateTimeInterface $dateLibre): self
    {
        $this->dateLibre = $dateLibre;

        return $this;
    }

    public function getNumeroprop(): ?Proprietaires
    {
        return $this->numeroprop;
    }

    public function setNumeroprop(?Proprietaires $numeroprop): self
    {
        $this->numeroprop = $numeroprop;

        return $this;
    }

    public function getProprietaire(): ?int
    {
        return $this->proprietaire;
    }

    public function setProprietaire(int $proprietaire): self
    {
        $this->proprietaire = $proprietaire;

        return $this;
    }

    public function getNumeroloc(): ?Locataires
    {
        return $this->numeroloc;
    }

    public function setNumeroloc(?Locataires $numeroloc): self
    {
        $this->numeroloc = $numeroloc;

        return $this;
    }


    /**
     * @return Collection|Clients[]
     */
    public function getNumCli(): Collection
    {
        return $this->numCli;
    }

    public function addNumCli(Clients $numCli): self
    {
        if (!$this->numCli->contains($numCli)) {
            $this->numCli[] = $numCli;
            $numCli->addNumappart($this);
        }

        return $this;
    }

    public function removeNumCli(Clients $numCli): self
    {
        if ($this->numCli->contains($numCli)) {
            $this->numCli->removeElement($numCli);
            $numCli->removeNumappart($this);
        }

        return $this;
    }

    public function getTypAppart(): ?Typeappart
    {
        return $this->typappart;
    }

    public function setTypAppart(?Typeappart $typappart): self
    {
        $this->typappart = $typappart;

        return $this;
    }

    public function getLocataire(): ?int
    {
        return $this->locataire;
    }

    public function setLocataire(int $locataire): self
    {
        $this->locataire = $locataire;

        return $this;
    }

    /*public function __toString(): ?string
    {
        return $this->getTypAppart();
    }*/


}
