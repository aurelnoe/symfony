<?php

namespace App\Service\Interfaces;

interface ProduitInterface
{
    //public function addProduit(object $objet);

    //public function updateProduit(object $objet);

    public function deleteProduit(Object $id);

    public function getProduitById(Object $id);

    public function getProduits();
}
