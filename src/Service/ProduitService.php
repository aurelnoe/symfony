<?php
namespace App\Service;

use App\Entity\Produit;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProduitService extends AbstractController
{
    private $produit;

    public function __construct(ProduitRepository $produitRepository) 
    {
        $this->produit = $produitRepository;
    }

    public function getProduits(){
        $produits = $this->produit->findAll();
        return $produits;
    }

    public function getProduitById($id){
        $produit = $this->produit->find($id);
        return $produit; 
    }

    public function deleteProduit($id){
        $produit = $this->produit->find($id);
        $entitymanager = $this->getDoctrine()->getManager();
        $entitymanager->remove($produit);
        $entitymanager->flush();
        return $this->getProduits();
    }
}