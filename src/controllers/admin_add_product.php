<?php 

// Initialisation
$errors = null;

// Si le formulaire est soumis 
if (!empty($_POST)) {
    
    // Récupération des données du formulaire
    $name = strip_tags($_POST['name']);
    $description = strip_tags($_POST['description']);
    $price = str_replace(',', '.', $_POST['price']);
    $stock = intval($_POST['stock']);
    $categoryId = intval($_POST['category']);
    $creatorId = intval($_POST['creator']);

    // TODO adapter l'ajout des images avec js (faire apparaitre des champs à la demande)
    // TODO ajout de l'upload directement
    $pictureA = strip_tags($_POST['picture_1']);
    $pictureB = strip_tags($_POST['picture_2']);
    $pictureC = strip_tags($_POST['picture_3']);
    $pictureD = strip_tags($_POST['picture_4']);
    
    // Validation des données
    $errors = validateProductForm($name, $description, $price, $stock); 
    
    // Si tout est OK
    if (empty($errors)) {

        // Insertion du produit dans la BDD
        (new ProductModel())->insertProduct($name, $description, $price, $stock, $categoryId, $creatorId, $pictureA, $pictureB, $pictureC, $pictureD);

        // Message flash
        (new Flashbag())->addFlashMessage('Produit correctement ajouté');

        // Redirection vers le dashboard admin
        header('Location:/admin/product');
        exit;
    }
}    

// Sélection des catégories
$categories = (new CategoryModel())->getAllCategories();

// Sélection des créateurs
$creators = (new CreatorModel())->getAllCreators();

// Affichage du formulaire
render('admin_add_product', [
    'pageTitle' => 'Ajouter un produit',
    'categories' => $categories,
    'creators' => $creators,
    'errors' => $errors
], 'base_admin');