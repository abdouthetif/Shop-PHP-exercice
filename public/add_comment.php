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
    
    // Récupération du commentaire et son titre, de l'id du produit et du nombre d'étoiles
    $comment = $_POST['comment'];
    $productId = $_POST['productId'];
    $rating = $_POST['starRate'];
    $title = $_POST['title'];

    // Ajout du commentaire et ses informations dans la BDD
    addComment($comment, $title, $productId, $rating);

    // Création d'un message flash
    addFlashMessage('Votre commentaire a bien été pris en compte.');

    
    // Redirection vers la page du produit
    header('Location: product-details.php?productId='.$productId);
}
