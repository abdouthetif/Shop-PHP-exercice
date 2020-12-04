<?php

// Inclusion des dépendances
require '../src/functions.php';

// Récupère tous les produits
$products = getAllProducts();

// Inclusion du fichier de template et ses variables
$pageTitle = 'Welcome to my shop!';
$template_bg = 'bg-dark';
render('index', [
    'products' => $products,
    'pageTitle' => $pageTitle, 
    'template_bg' => $template_bg
]);