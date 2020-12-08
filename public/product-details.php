<?php

// Inclusion des dépendances
require '../src/functions.php';

// Si problème avec l'id du produit -> message d'erreur + exit;
if (!isset($_GET['productId'])) {
    echo 'Error : no valid product id';
    exit;
}

// $productId = (int) $_GET['id'];
$productId = intval($_GET['productId']);

// Récupération des détails d'un produit
$productDetails = getProductById($productId);

// Récupération de tous les commentaires
$comments = getCommentsByProductId($productId);

/* GET PICTURE FOR AJAX
$picture_1 = $productDetails['picture_1'];
$picture_2 = $productDetails['picture_2'];
$picture_3 = $productDetails['picture_3'];
$picture_4 = $productDetails['picture_4'];

$productPictures = [];
$productPictures = [
    'status' => 'success',
    'pictures' => [
        1,
        2,
        3,
        4
    ]
];
echo json_encode($productPictures);
*/

// Inclusion du fichier de template et ses variables
$pageTitle = $productDetails['name'];
render('product-details', [
    'productDetails' => $productDetails,
    'comments' => $comments,
    'pageTitle' => $pageTitle, 
    'template_bg' => 'bg-light'
]);