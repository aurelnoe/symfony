<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Service\CategorieService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\Exception\CategorieServiceException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/categorie")
 */
class CategorieController extends AbstractController
{
    /**
     * @Route("/", name="categorie_index")
     */
    public function index(CategorieService $service): Response
    {
        try {
            $categories = $service->getCategories();   

            return $this->render('categorie/index.html.twig', [
                'categories' => $categories,
            ]);       
        } 
        catch (CategorieServiceException $cse) 
        {
            return $this->render('categorie/index.html.twig', [
                'erreur' => $cse->getMessage()
            ]);
        }
    }

    /**
     * @Route("/create", name="categorie_create")
     * 
     * @IsGranted("ROLE_USER")
     */
    public function create(Request $request, CategorieService $service): Response
    {
        try {
            $categorie = new Categorie();
    
            $form = $this->createForm(CategorieType::class, $categorie);
    
            $form->handleRequest($request);
    
            if ($form->isSubmitted() && $form->isValid()) 
            {
                $service->addCategorie($categorie);
    
                return $this->redirectToRoute('categorie_index');
            }
            return $this->render('categorie/create.html.twig', [
                'form' => $form->createView(),
            ]);
        } 
        catch (CategorieServiceException $cse) 
        {
            return $this->render('categorie/create.html.twig', [
                'form' => $form->createView(),
                'erreur' => $cse->getMessage()
            ]);
        }
    }
}
