<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProduitRepository;
use Symfony\Component\Validator\Constraints as Assert; 
/**
 * @ORM\Entity(repositoryClass=ProduitRepository::class)
 */
class Produit
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le produit doit avoir une désignation")
     * @Assert\Length(min=3, max=255, minMessage="Le titre doit faire plus de 3 caractères !",
     *                                maxMessage="Le titre ne peut pas faire plus de 255 caractères !")
     */
    private $designation;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank(message="Le produit doit avoir un prix")
     * @Assert\Length(min=1, max=7, minMessage="Le prix doit faire plus de 1&euro !",
     *                                maxMessage="Le prix ne peut pas faire plus de 7 chiffres !")
     */
    private $prix;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(message="Le produit doit avoir une couleur")
     * @Assert\Length(min=3, max=10, minMessage="La couleur doit faire plus de 3 caractères !",
     *                                maxMessage="La couleur ne peut pas faire plus de 10 caractères !")
     */
    private $couleur;

    /**
     * @ORM\ManyToOne(targetEntity=Categories::class, inversedBy="produit")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categorie;

    public function __toString()
    {
        return
        $this->designation;
        $this->prix;
        $this->couleur;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): self
    {
        $this->designation = $designation;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getCouleur(): ?string
    {
        return $this->couleur;
    }

    public function setCouleur(string $couleur): self
    {
        $this->couleur = $couleur;

        return $this;
    }

    public function getCategorie(): ?Categories
    {
        return $this->categorie;
    }

    public function setCategorie(?Categories $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }
}
