<?php 

// Inclusion des dépendances
require '../src/functions.php';

// Autorisation : l'utilisateur est-il connecté et a-t-il le rôle ADMIN ?
verifyAdmin();

// Sélection des produits
$products = getAllProducts();

// Affichage
render('admin', [
    'pageTitle' => 'Dashboard admin',
    'products' => $products, 
    'template_bg' => 'bg-light'
], 'base_admin');