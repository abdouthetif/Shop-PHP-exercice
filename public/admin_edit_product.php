<?php 

// Inclusion des dépendances
require '../src/functions.php';

// Autorisation : l'utilisateur est-il connecté et a-t-il le rôle ADMIN ?
if (!isAuthenticated() || $_SESSION['user']['role'] != ROLE_ADMIN) {
    http_response_code(403);
    echo "Vous n'êtes pas autorisé à accéder à cette page.";
    exit;
}

// Initialisations
$errors = null;

// Si le formulaire est soumis 
if (!empty($_POST)) {

    // Récupérer les données du formulaire
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = str_replace(',', '.', $_POST['price']);
    $stock = $_POST['stock'];
    $categoryId = intval($_POST['category']);
    $creatorId = intval($_POST['creator']);
    $picture = $_POST['picture'];
    $productId = intval($_POST['product-id']);

    // Validation des données
    $errors = validateProductForm($name, $description, $price, $stock);

    // Si tout est OK
    if (empty($errors)) {

        // Insertion du produit dans la BDD
        updateProduct($productId, $name, $description, $price, $stock, $categoryId, $creatorId, $picture);

        // Message flash puis redirection vers le dashboard admin
        addFlashMessage('Produit correctement mis à jour');
        header('Location: admin.php');
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
$product = getProductById($productId);

// Sélection des catégories
$categories = getAllCategories();

// Sélection des créateurs
$creators = getAllCreators();

// Affichage du formulaire
render('admin_edit_product', [
    'pageTitle' => 'Modifier un produit',
    'categories' => $categories,
    'creators' => $creators,
    'product' => $product,
    'errors' => $errors
], 'base_admin');