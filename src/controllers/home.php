<?php

use App\Model\ProductModel;

// On crée un objet de la classe ProductModel
$productModel = new ProductModel();

// On fait ensuite appel à la méthode getAllProducts() sur notre objet pour récupèrer tous les produits
$products = $productModel->getAllProducts();

// Inclusion du fichier de template et ses variables
render('home', [
    'products' => $products,
    'pageTitle' => 'Welcome to my shop!', 
    'template_bg' => 'bg-dark'
]);