<?php

namespace App\Service\Interfaces;

interface CategorieInterface
{
    public function addCategorie(object $objet);

    public function updateCategorie();

    public function deleteCategorie(Object $id);

    public function getCategorieById(Object $id);

    public function getCategories();
}