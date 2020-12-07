<?php

// Inclusion des dépendances
require '../src/functions.php';

// Autorisation : l'utilisateur est-il connecté et a-t-il le rôle ADMIN ?
if (!isAuthenticated() || $_SESSION['user']['role'] != ROLE_ADMIN) {
    http_response_code(403);
    echo "Vous n'êtes pas autorisé à accéder à cette page.";
    exit;
}

// Récupération de l'id du produit à modifier dans la chaîne de requête de l'URL
if (!array_key_exists('id', $_GET) || !isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    echo 'Error : no product id parameter';
    exit;
}

$productId = $_GET['id'];

removeProduct($productId);

// Ajout d'un message flash et redirection vers le dashboard
addFlashMessage('Le produit est maintenant supprimé.');
header('Location: admin.php');
exit;
