<?php
namespace App\Service;

use App\Entity\Produit;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\DBAL\Exception\DriverException;
use App\Service\Exception\ProduitServiceException;
use App\Service\Interfaces\ProduitInterface;

class ProduitService implements ProduitInterface
{
    private $produitRepository;
    private $produitManager;

    public function __construct(ProduitRepository $produitRepository,EntityManagerInterface $produitManager) 
    {
        $this->produitRepository = $produitRepository;
        $this->produitManager = $produitManager;
    }

    public function getProduits()
    {
        try {
            $produits = $this->produitRepository->findAll();
            return $produits;     
        } 
        catch (DriverException $e) {
            throw new ProduitServiceException("Un problème technique est survenu", $e->getCode());
        }
    }

    public function getProduitById(Object $id)
    {
        try {
            $produit = $this->produitRepository->find($id);
            return $produit; 
        } 
        catch (DriverException $e) {
            throw new ProduitServiceException("Un problème technique est survenu", $e->getCode());
        }
    }

    public function deleteProduit(Object $id)
    {
        try {
            $produit = $this->produitRepository->find($id);
            $this->produitManager->remove($produit);
            $this->produitManager->flush();
        } 
        catch (DriverException $e) {
            throw new ProduitServiceException("Un problème technique est survenu", $e->getCode());
        }
    }
}