<?php

use App\Model\ProductModel;
use App\Model\CategoryModel;
use App\Model\CreatorModel;

// Sélection des produits
$products = (new ProductModel())->getAllProducts();

// Initialisations
$creators = '';
$categories = '';
$creatorName = '';
$categoryName = '';
$categoryModel = new CategoryModel();
$creatorModel = new CreatorModel();

// Vérifie si l'url contient 'category' 
if (isset($_GET['category'])) {

    // Récupère toutes les catégories
    $categories = $categoryModel->getAllCategories();

    // Vérifie si l'url contient un id
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Récupère une categorie selon son id
        $categoryName = $categoryModel->getCategoryById($id);
    }
}

// Vérifie si l'url contient 'creator' 
if (isset($_GET['creator'])) {

    // Récupère tous les créateurs
    $creators = $creatorModel->getAllCreators();

    // Vérifie si l'url contient un id
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Récupère un créateur selon son id
        $creatorName = $creatorModel->getCreatorById($id);
    }
}

// Affichage
render('admin', [
    'pageTitle' => 'Dashboard admin',
    'products' => $products, 
    'categories' => $categories,
    'categoryName' => $categoryName,
    'creators' => $creators,
    'creatorName' => $creatorName,
    'template_bg' => 'bg-light'
], 'base_admin');