<?php

namespace App\Service\Interfaces;

use App\Entity\Produit;

interface ProduitInterface
{
    //public function addProduit(object $objet);

    //public function updateProduit(object $objet);
    
    public function getProduits();

    public function deleteProduit(Produit $id);

    public function getProduitById(Produit $id);

}
