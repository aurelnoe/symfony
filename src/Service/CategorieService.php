<?php
namespace App\Service;

use App\Entity\Categories;
use App\Repository\CategoriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategorieService extends AbstractController
{
    private $categorie;

    public function __construct(CategoriesRepository $categorieRepository) 
    {
        $this->categorie = $categorieRepository;
    }

    public function getCategories(){
        $categories = $this->categorie->findAll();
        return $categories;
    }

    public function getCategorieById($id){
        $categorie = $this->categorie->find($id);
        return $categorie; 
    }

    public function addCategorie(){
        $categorie = new Categories();

        $manager = $this->getDoctrine()->getManager();
        $manager->persist($categorie);
        $manager->flush();

        return $categorie; 
    }

    public function deleteCategorie($id){
        $categorie = $this->categorie->find($id);
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($categorie);
        $manager->flush();
        return $this->getcategories();
    }
}