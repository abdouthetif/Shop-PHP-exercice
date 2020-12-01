<?php

// Inclusion des dépendances
require '../src/functions.php';

// Si problème avec l'id du produit -> message d'erreur + exit;
if (!isset($_GET['prudctId'])) {
    echo 'Error : no valid product id';
    exit;
}

// $productId = (int) $_GET['id'];
$product = intval($_GET['prudctId']);

// Récupération des détails d'un produit
$productDetails = getProduct($product);

/* Inclusion du fichier de template */
$pageTitle = $productDetails['name'];
$template = 'product-details';
$template_bg = 'bg-light';
include '../templates/base.phtml';