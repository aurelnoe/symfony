<?php

namespace App\Service\Interfaces;

use App\Entity\Categorie;

interface CategorieInterface
{
    public function addCategorie(Categorie $categorie);

    public function updateCategorie();

    public function deleteCategorie(Categorie $id);

    public function getCategorieById(Categorie $id);

    public function getCategories();
}