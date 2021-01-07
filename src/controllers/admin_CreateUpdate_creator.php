<?php

use App\Model\CreatorModel;

// Initialisation
$errors = null;

if (!empty($_POST)) {

    // Récupérer les données du formulaire
    $creatorId = intval($_POST['creatorId']);
    $creatorName = strip_tags($_POST['creatorName']);

    // Vérifie s'il faut ajouter ou mettre à jour une catégorie
    (new CreatorModel())->addUpdateCreator($creatorId, $creatorName);
}