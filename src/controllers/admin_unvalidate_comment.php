<?php

// Récupération de l'id du produit à modifier dans la chaîne de requête de l'URL
if (!array_key_exists('id', $_GET) || !isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    echo 'Error : no product id parameter';
    exit;
}

$commentId = $_GET['id'];

// Invalidation du commentaire
$commentModel = new CommentModel();
$commentModel->updateCommentValidation($commentId, false);

// Ajout d'un message flash et redirection vers le dashboard
$flashModel = new Flashbag();
$flashModel->addFlashMessage('Le commentaire a correctement été invalidé.');
header('Location: /admin/comment');
exit;