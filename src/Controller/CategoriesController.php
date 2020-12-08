<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Form\CategoriesType;
use App\Repository\CategoriesRepository;
use App\Service\CategorieService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/categories")
 */
class CategoriesController extends AbstractController
{
    /**
     * @Route("/", name="categories_index")
     */
    public function index(CategorieService $service): Response
    {
        $categories = $service->getCategories();

        return $this->render('categories/index.html.twig', [
            'controller_name' => 'CategoriesController',
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/create", name="categories_create")
     */
    public function create(Request $request, CategorieService $service): Response
    {
        $categories = new Categories();

        $form = $this->createForm(CategoriesType::class, $categories);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $service->addCategorie();

            return $this->redirectToRoute('categories_index');
        }

        return $this->render('categories/create.html.twig', [
            'controller_name' => 'CategoriesController',
            'form' => $form->createView()
        ]);
    }
}
