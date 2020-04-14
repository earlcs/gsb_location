<?php

namespace App\Entity;

use DateTimeInterface;
use App\Entity\Typeappart;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Demandes
 *
 * @ORM\Table(name="demandes", indexes={@ORM\Index(name="I_FK_DEMANDES_CLIENTS", columns={"NUM_CLI"})})
 * @ORM\Entity
 */
class Demandes
{
    /**
     * @var int
     *
     * @ORM\Column(name="NUM_DEM", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $numDem;

    /**
     * @var \Typeappart
     *
     * @ORM\ManyToOne(targetEntity="Typeappart")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="TYPE_DEM", referencedColumnName="TYPE_APPART")
     * })
     */
    private $typeDem;

    /**
     * @ORM\Column(name="TYPE_DEM", type="string", nullable=false)
     */
    private $typeappart;

    /**
     * @var \Date|null
     *
     * @ORM\Column(name="DATE_LIMITE", type="date", nullable=true, options={"default"="NULL"})
     */
    private $dateLimite; /*= '';*/

    /**
     * @var \Clients
     *
     * @ORM\ManyToOne(targetEntity="Clients")
     * @ORM\JoinColumn(name="NUM_CLI", referencedColumnName="NUM_CLI")
     * 
     */
    private $numCli;

    /**
     * 
     * @ORM\Column(name="NUM_CLI", type="integer", nullable=false)
     */
    private $clients;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Arrondissement", inversedBy="numDem")
     * @ORM\JoinTable(name="concerner",
     *   joinColumns={
     *     @ORM\JoinColumn(name="NUM_DEM", referencedColumnName="NUM_DEM")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="ARRONDISS_DEM", referencedColumnName="ARRONDISS_DEM")
     *   }
     * )
     */
    private $arrondissDem;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->arrondissDem = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getNumDem(): ?int
    {
        return $this->numDem;
    }

    public function getTypeDem(): ?Typeappart
    {
        return $this->typeDem;
    }

    public function setTypeDem(Typeappart $typeDem): self
    {
        $this->typeDem = $typeDem;

        return $this;
    }

    public function getDateLimite(): ?\DateTimeInterface
    {
        return $this->dateLimite;
    }

    public function setDateLimite(?\DateTimeInterface $dateLimite): self
    {
        $this->dateLimite = $dateLimite;

        return $this;
    }

    public function getNumCli(): ?Clients
    {
        return $this->numCli;
    }

    public function setNumCli(?Clients $numCli): self
    {
        $this->numCli = $numCli;

        return $this;
    }

    public function getClients(): ?int
    {
        return $this->clients;
    }

    public function setClients(int $clients): self
    {
        $this->clients = $clients;

        return $this;
    }

    /**
     * @return Collection|Arrondissement[]
     */
    public function getArrondissDem(): Collection
    {
        return $this->arrondissDem;
    }

    public function addArrondissDem(Arrondissement $arrondissDem): self
    {
        if (!$this->arrondissDem->contains($arrondissDem)) {
            $this->arrondissDem[] = $arrondissDem;
        }

        return $this;
    }

    public function removeArrondissDem(Arrondissement $arrondissDem): self
    {
        if ($this->arrondissDem->contains($arrondissDem)) {
            $this->arrondissDem->removeElement($arrondissDem);
        }

        return $this;
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


}
