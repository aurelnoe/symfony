<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\AdresseRepository;
use Symfony\Component\Validator\Constraints as Assert; 
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @ORM\Entity(repositoryClass=AdresseRepository::class)
 */
class Adresse
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Il faut un libellé à l'adresse")
     * @Assert\Length(min=1, max=7, minMessage="Le libellé doit faire plus de 3 caractères !",
     *                                maxMessage="Le libellé ne peut pas faire plus de 200 caractères !")
     */
    private $libelle;

    public function __toString()
    {
        return
        $this->id .
        $this->libelle;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }
}
