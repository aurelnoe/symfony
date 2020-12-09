<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Form\CategoriesType;
use App\Service\CategoriesService;
use App\Service\Exception\CategorieServiceException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/categorie")
 */
class CategoriesController extends AbstractController
{
    /**
     * @Route("/", name="categories_index")
     */
    public function index(CategoriesService $service): Response
    {
        try {
            $categories = $service->getCategories();   

            return $this->render('categorie/index.html.twig', [
                'controller_name' => 'CategoriesController',
                'categories' => $categories,
                'erreur' => null
            ]);       
        } 
        catch (CategorieServiceException $cse) 
        {
            return $this->render('categorie/index.html.twig', [
                'controller_name' => 'CategoriesController',
                'erreur' => $cse->getMessage()
            ]);
        }
    }

    /**
     * @Route("/create", name="categories_create")
     */
    public function create(Request $request, CategoriesService $service): Response
    {
        try {
            $categories = new Categories();
    
            $form = $this->createForm(CategoriesType::class, $categories);
    
            $form->handleRequest($request);
    
            if ($form->isSubmitted() && $form->isValid()) 
            {
                $service->addCategorie($categories);
    
                return $this->redirectToRoute('categories_index');
            }
        } 
        catch (CategorieServiceException $cse) 
        {
            return $this->render('categorie/create.html.twig', [
                'controller_name' => 'CategoriesController',
                'form' => $form->createView(),
                'erreur' => $cse->getMessage()
            ]);
        }
    }
}
