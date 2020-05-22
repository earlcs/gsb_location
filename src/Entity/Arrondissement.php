<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Arrondissement
 *
 * @ORM\Table(name="arrondissement")
 * @ORM\Entity
 */
class Arrondissement
{
    /**
     * @var int
     *
     * @ORM\Column(name="ARRONDISS_DEM", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $arrondissDem;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Demandes", mappedBy="arrondissDem")
     */
    private $numDem;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->numDem = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @return Collection|Demandes[]
     */
    public function getNumDem(): Collection
    {
        return $this->numDem;
    }

    public function addNumDem(Demandes $numDem): self
    {
        if (!$this->numDem->contains($numDem)) {
            $this->numDem[] = $numDem;
            $numDem->addArrondissDem($this);
        }

        return $this;
    }

    public function removeNumDem(Demandes $numDem): self
    {
        if ($this->numDem->contains($numDem)) {
            $this->numDem->removeElement($numDem);
            $numDem->removeArrondissDem($this);
        }

        return $this;
    }

    public function getArrondissDem(): ?int
    {
        return $this->arrondissDem;
    }

    public function __toString()
    {
        return (string) $this->getArrondissDem();
    }

}
