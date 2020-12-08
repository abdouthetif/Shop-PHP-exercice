<?php

// Inclusion des dépendances
require '../src/functions.php';

// Autorisation : l'utilisateur est-il connecté et a-t-il le rôle ADMIN ?
verifyAdmin();

// Récupération de l'id du produit à modifier dans la chaîne de requête de l'URL
if (!array_key_exists('id', $_GET) || !isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    echo 'Error : no product id parameter';
    exit;
}

$commentId = $_GET['id'];

updateCommentValidation($commentId, true);

// Ajout d'un message flash et redirection vers le dashboard
addFlashMessage('Le commentaire a correctement été validé.');
header('Location: admin_comments.php');
exit;