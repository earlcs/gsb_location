<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Typeappart
 *
 * @ORM\Table(name="typeappart")
 * @ORM\Entity
 */
class Typeappart
{
    /**
     * @var string
     *
     * @ORM\Column(name="TYPE_APPART", type="string", length=30, nullable=false, options={"fixed"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $typeAppart;

    public function getTypeAppart(): ?string
    {
        return $this->typeAppart;
    }

    /*public function setTypeAppart(string $typeAppart): ?string
    {
        $this->typeAppart = $typeAppart;

        return $this;
    }*/

    public function __toString()
    {
        return (string) $this->getTypeAppart();
    }


}
