<?php
namespace App\Service;

use App\Repository\CategoriesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\DBAL\Exception\DriverException;
use App\Service\Exception\CategorieServiceException;
use App\Service\Interfaces\CategorieInterface;

class CategoriesService implements CategorieInterface
{
    private $catRepository;
    private $catManager;

    public function __construct(CategoriesRepository $categorieRepository,EntityManagerInterface $categorieManager) 
    {
        $this->catRepository = $categorieRepository;
        $this->catManager = $categorieManager;
    }

    public function getCategories()
    {
        try {
            
            return $this->catRepository->findAll();
        } 
        catch (DriverException $e) {
            throw new CategorieServiceException("Un problème technique est survenu", $e->getCode());
        }
        
    }

    public function getCategorieById(Object $id)
    {
        try {
            
            return $this->catRepository->find($id);
        } 
        catch (DriverException $e) {
            throw new CategorieServiceException("Un problème technique est survenu", $e->getCode());
        }
    }

    public function addCategorie(Object $categorie)
    {
        try {
    
            $this->catManager->persist($categorie);
            $this->catManager-flush();   
        } 
        catch (DriverException $e) {
            throw new CategorieServiceException("Un problème technique est survenu", $e->getCode());
        }
    }

    public function updateCategorie()
    {
        try {
            $this->catManager-flush();
        } 
        catch (DriverException $e) {
            throw new CategorieServiceException("Un problème technique est survenu", $e->getCode());
        }
    }

    public function deleteCategorie(Object $id)
    {
        try {
            $categorie = $this->categorie->find($id);
            $this->catManager->remove($categorie);
            $this->catManager->flush();
    
            return $this->getCategories();            
        } 
        catch (DriverException $e) {
            throw new CategorieServiceException("Un problème technique est survenu", $e->getCode());
        }
    }
}