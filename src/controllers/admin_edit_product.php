<?php

use App\Service\Flashbag;
use App\Model\ProductModel;
use App\Model\CategoryModel;
use App\Model\CreatorModel;

// Initialisations
$errors = null;
$productModel = new ProductModel();
$categoryModel = new CategoryModel();
$creatorModel = new CreatorModel();
$flashModel = new Flashbag();

// Si le formulaire est soumis 
if (!empty($_POST)) {

    // Récupérer les données du formulaire
    $name = strip_tags($_POST['name']);
    $description = strip_tags($_POST['description']);
    $price = str_replace(',', '.', $_POST['price']);
    $stock = intval($_POST['stock']);
    $categoryId = intval($_POST['category']);
    $creatorId = intval($_POST['creator']);
    $productId = intval($_POST['product-id']);


    $pictureA = $_POST['picture_1'];
    $pictureB = $_POST['picture_2'];
    $pictureC = $_POST['picture_3'];
    $pictureD = $_POST['picture_4'];

    // Validation des données
    $errors = validateProductForm($name, $description, $price, $stock);

    // Si tout est OK
    if (empty($errors)) {

        // Insertion du produit dans la BDD
        $productModel->updateProduct($productId, $name, $description, $price, $stock, $categoryId, $creatorId, $pictureA, $pictureB, $pictureC, $pictureD);

        // Message flash puis redirection vers le dashboard admin
        $flashModel->addFlashMessage('Produit correctement mis à jour');
        header('Location: /admin/product');
        exit;
    }
}

// Récupération de l'id du produit à modifier dans la chaîne de requête de l'URL
if (!isset($productId) && (!array_key_exists('id', $_GET) || !isset($_GET['id']) || !ctype_digit($_GET['id']))) {
    echo 'Error : no product id parameter';
    exit;
}

// Si tout est ok on récupère l'id du produit 
$productId = $productId??$_GET['id'];

// Sélection du produit à modifier (pour pré remplir le formulaire)
$product = $productModel->getProductById($productId);

// Sélection des catégories
$categories = $categoryModel->getAllCategories();

// Sélection des créateurs
$creators = $creatorModel->getAllCreators();

// Affichage du formulaire
render('admin_edit_product', [
    'pageTitle' => 'Modifier un produit',
    'categories' => $categories,
    'creators' => $creators,
    'product' => $product,
    'errors' => $errors
], 'base_admin');