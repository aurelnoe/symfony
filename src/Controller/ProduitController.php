<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use App\Service\ProduitService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\DBAL\Exception\ConnectionException;
use App\Service\Exception\ProduitServiceException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/produit")
 */
class ProduitController extends AbstractController
{
    /**
     * @Route("/", name="produit_index")
     */
    public function index(ProduitService $service): Response
    {        
        try {
            $produits = $service->getProduits(); 
            return $this->render('produit/index.html.twig', [
                'controller_name' => 'ProduitController',
                'title' => 'Liste des produits',
                'produits' => $produits,
                'erreur' => null
            ]);            
        } 
        catch (ProduitServiceException $pse) {
            return $this->render('produit/index.html.twig', [
                'controller_name' => 'ProduitController',
                'title' => 'Liste des produits',
                'erreur' => $pse->getMessage()
            ]);
        }
    }

    /**
     * @Route("/new", name="produit_new")
     * 
     * @Route("/{id}/edit", name="produit_edit",requirements={"id","\d+"})
     *  
     */
    public function AddUpdateProduit(Produit $produit = null, Request $request, EntityManagerInterface $manager)
    {
        //array_map('strToLower', $produit);
        //dump($request);

        $title = 'Modifier un produit';
        $titleBtn = 'Modifier';
        $isAdd = false;
        if (!$produit) {
            $produit = new Produit();
            $isAdd = true;
            $title = 'Ajouter un produit';
            $titleBtn = 'Ajouter';
        }

        try {
            $form = $this->createForm(ProduitType::class, $produit);
    
            $form->handleRequest($request);
    
            if ($form->isSubmitted() && $form->isValid()) 
            {
                //$manager = $this->getDoctrine()->getManager();
                $manager->persist($produit);
                $manager->flush();
    
                if ($isAdd) 
                {
                    $this->addFlash(
                        'success',                                                                         //Type
                        "Le produit <strong>{$produit->getDesignation()}</strong> a bien été enregistré"    //Message
                    );
                }
                else {
                    $this->addFlash(
                        'success',                                                                        
                        "Le produit <strong>{$produit->getDesignation()}</strong> a été modifié avec succès"    
                    );
                }
    
                return $this->redirectToRoute('produit_show', ['id' => $produit->getId()]);
            }
    
            if ($form->isSubmitted() && !($form->isValid())) 
            {
                if ($isAdd) {
                    $this->addFlash(
                        'danger',                                                                        
                        "Le produit <strong>{$produit->getDesignation()}</strong> n'a pas été enregistré"    
                    );
                    $this->addFlash(
                        'danger',                                                                    
                        "Veuillez réessayer"   
                    );
                }
                else {
                    $this->addFlash(
                        'danger',                                                                        
                        "Le produit <strong>{$produit->getDesignation()}</strong> n'a pas été modifié"    
                    );
                }
                
            }
            
        } 
        catch (ProduitServiceException $pse) 
        {
            return $this->render('produit/new.html.twig', [
                'controller_name' => 'ProduitController',
                'form' => $form->createView(),
                'title' => $title,
                'titleBtn' => $titleBtn,
            ]);           
        }
    }

    /**
     * @Route("/show/{id}",name="produit_show",requirements={"id","\d+"},methods={"GET"})
     */
    
    public function show(ProduitService $service,Produit $id): Response
    {
        try 
        {
            $produit = $service->getProduitById($id); //Plus besoin   
        } 
        catch (ProduitServiceException $pse) 
        {
            return $this->render('produit/show.html.twig', [
                'controller_name' => 'ProduitController',
                'produit' => $produit,
                'title' => 'Détails produit',
            ]);       
        }
    }

    /**
     * @Route("/{id}", name="produit_delete",requirements={"id","\d+"},methods={"DELETE"})
     */
    public function delete(Request $request,Produit $produit,Produit $id, ProduitService $service): Response
    {
        try 
        {
            if ($this->isCsrfTokenValid('delete' . $produit->getId(), $request->get('_token'))) 
            {
                $service->deleteProduit($id);
            }
    
            return $this->redirectToRoute('produit_index');      
        } 
        catch (ConnectionException $ce) {
            throw $ce;
        }
    }
}
