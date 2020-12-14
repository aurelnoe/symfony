<?php

namespace App\Entity;

use App\Entity\Adresse;
use App\Entity\Produit;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ClientRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert; 

/**
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 */
class Client
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(message="Le nom est obligatoire")
     * @Assert\Length(min=1, max=7, minMessage="Le nom doit faire plus de 3 caractères !",
     *                                maxMessage="Le nom ne peut pas faire plus de 100 caractères !")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(message="Le prénom est obligatoire")
     * @Assert\Length(min=1, max=7, minMessage="Le prénom doit faire plus de 3 caractères !",
     *                                maxMessage="Le prénom ne peut pas faire plus de 100 caractères !")
     */
    private $prenom;

    /**
     * @ORM\ManyToMany(targetEntity=Produit::class, inversedBy="clients")
     */
    private $produit;

    /**
     * @ORM\OneToOne(targetEntity=Adresse::class, inversedBy="clients", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $adresse;

    public function __construct()
    {
        $this->produit = new ArrayCollection();
    }

    public function __toString()
    {
        return
        $this->id .
        $this->nom .
        $this->prenom .
        $this->produit .
        $this->adresse;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * @return Collection|Produit[]
     */
    public function getProduit(): Collection
    {
        return $this->produit;
    }

    public function addProduit(Produit $produit): self
    {
        if (!$this->produit->contains($produit)) {
            $this->produit[] = $produit;
        }

        return $this;
    }

    public function removeProduit(Produit $produit): self
    {
        $this->produit->removeElement($produit);

        return $this;
    }

    public function getAdresse(): ?Adresse
    {
        return $this->adresse;
    }

    public function setAdresse(Adresse $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }
}

// INSERT INTO `client` (`id`, `nom`, `prenom`, `adresse_id`) VALUES
// (1, 'dupont', 'francois', '25 rue Henry Boucher Paris'),
// (2, 'dujardin', 'francois', '25 rue Charle Boucher Paris'),
// (3, 'dubois', 'jane', '25 rue Jacque Brel Paris'),
// (4, 'lasalle', 'greg', '25 rue Francois Mitterand Paris'),
// (5, 'glitter', 'gary', '25 rue Long Fleuve Paris'),
// (6, 'mousse', 'pierre', '25 rue Coin Perdu Paris'),
// (7, 'bros', 'mario', '25 rue Henry Duval Paris'),
// (8, 'labelle', 'jeanne', '25 rue Pierre Richard Paris'),
// (9, 'jordan', 'mike', '25 rue Paul Pogba Paris'),
// (10, 'tootoo', 'tutu', '25 rue Henry ejnejz Paris'),
// (11, 'mcgregor', 'conor', '22 rue Orphelinat Hazebrouck'),
// (12, 'zidane', 'zinedine', '22 rue Champs Elizée Paris');
