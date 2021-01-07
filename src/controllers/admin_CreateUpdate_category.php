<?php

// Initialisation
$errors = null;

if (!empty($_POST)) {

    // Récupérer les données du formulaire
    $categoryId = intval($_POST['categoryId']);
    $categoryName = strip_tags($_POST['categoryName']);

    // Vérifie s'il faut ajouter ou mettre à jour une catégorie
    (new CategoryModel())->addUpdateCategory($categoryId, $categoryName);
}