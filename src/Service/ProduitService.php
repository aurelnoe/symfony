<?php
namespace App\Service;

use App\Entity\Produit;
use App\Repository\ClientRepository;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\Interfaces\ProduitInterface;
use Doctrine\DBAL\Exception\DriverException;
use App\Service\Exception\ProduitServiceException;

class ProduitService implements ProduitInterface
{
    private $produitRepository;
    private $produitManager;
    private $clientRepository;

    public function __construct(ProduitRepository $produitRepository,ClientRepository $clientRepository,EntityManagerInterface $produitManager) 
    {
        $this->produitRepository = $produitRepository;
        $this->produitManager = $produitManager;
        $this->clientRepository = $clientRepository;
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

    public function getClients($produit)
    {
        try {
            $clients = $this->clientRepository->findByProduit($produit);
            return $clients;     
        } 
        catch (DriverException $e) {
            throw new ProduitServiceException("Un problème technique est survenu", $e->getCode());
        }
    }

    public function getProduitById(Produit $id)
    {
        try {
            $produit = $this->produitRepository->find($id);
            return $produit; 
        } 
        catch (DriverException $e) {
            throw new ProduitServiceException("Un problème technique est survenu", $e->getCode());
        }
    }

    public function deleteProduit(Produit $id)
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

