<?php 
// TODO admin_add_categories add categories edit delete

// Inclusion des dépendances
require '../src/functions.php';

// Autorisation : l'utilisateur est-il connecté et a-t-il le rôle ADMIN ?
if (!isAuthenticated() || $_SESSION['user']['role'] != ROLE_ADMIN) {
    http_response_code(403);
    echo "Vous n'êtes pas autorisé à accéder à cette page.";
    exit;
}

// Initialisation
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
    
    // Validation des données
    $errors = validateProductForm($name, $description, $price, $stock); 
    
    // Si tout est OK
    if (empty($errors)) {

        // Insertion du produit dans la BDD
        insertProduct($name, $description, $price, $stock, $categoryId, $creatorId, $picture);

        // Message flash puis redirection vers le dashboard admin
        addFlashMessage('Produit correctement ajouté');

        header('Location:admin.php');
        
        exit;
    }

}    


// Sélection des catégories
$categories = getAllCategories();

// Sélection des créateurs
$creators = getAllCreators();

// Affichage du formulaire
render('admin_add_product', [
    'pageTitle' => 'Ajouter un produit',
    'categories' => $categories,
    'creators' => $creators,
    'errors' => $errors
], 'base_admin');