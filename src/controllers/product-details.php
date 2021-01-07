<?php

// Récupération de l'id du produit dans l'url
$productId = intval($_GET['productId']);

// Récupération des détails d'un produit
$productDetails = (new ProductModel())->getProductById($productId);

// Si problème avec l'id du produit -> message d'erreur + exit;
if (!isset($productId) || empty($productDetails)) {
    (new Flashbag())->addFlashMessage("Erreur : le produit n'existe pas");
    header('Location: /');
    exit;
}

// Récupération de tous les commentaires
$comments = (new CommentModel())->getCommentsByProductId($productId);

// Inclusion du fichier de template et ses variables
$pageTitle = $productDetails['name'];
render('product-details', [
    'productDetails' => $productDetails,
    'comments' => $comments,
    'pageTitle' => $pageTitle, 
    'template_bg' => 'bg-light'
]);