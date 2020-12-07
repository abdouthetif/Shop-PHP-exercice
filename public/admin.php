<?php 

// Inclusion des dépendances
require '../src/functions.php';

// Autorisation : l'utilisateur est-il connecté et a-t-il le rôle ADMIN ?
if (!isAuthenticated() || $_SESSION['user']['role'] != ROLE_ADMIN) {
    http_response_code(403);
    echo "Vous n'êtes pas autorisé à accéder à cette page.";
    exit;
}

// Sélection des produits
$products = getAllProducts();

// Affichage
render('admin', [
    'pageTitle' => 'Dashboard admin',
    'products' => $products, 
    'template_bg' => 'bg-light'
], 'base_admin');