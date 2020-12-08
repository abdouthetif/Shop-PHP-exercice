<?php

// Inclusion des dépendances
require '../src/functions.php';

/* TODO gérer les messages d'erreur lié à la publication d'un commentaire */
if (empty($_POST['comment'])) {
    echo 'Le commentaire est vide.';
    exit;
}
else if (empty($_POST['starRate'])) {
    echo "Vous n'avez pas attribué de notes.";
    exit;
}
else if (empty($_POST['title'])) {
    echo "Vous n'avez pas renseigné le titre.";
    exit;
}
else {
    // TODO: add strip_tags on forms
    // Récupération du commentaire et son titre, de l'id du produit et du nombre d'étoiles
    $comment = strip_tags($_POST['comment']);
    $productId = intval($_POST['productId']);
    $rating = $_POST['starRate'];
    $title = strip_tags($_POST['title']);
    $userId = getUserId();

    // Ajout du commentaire et ses informations dans la BDD
    addComment($comment, $title, $productId, $rating, $userId);

    // Création d'un message flash
    addFlashMessage('Votre commentaire a bien été pris en compte.');

    
    // Redirection vers la page du produit
    header('Location: product-details.php?productId='.$productId);
}
