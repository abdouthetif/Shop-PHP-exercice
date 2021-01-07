<?php

use App\Service\Flashbag;
use App\Service\UserSession;
use App\Model\CommentModel;

// Initialise l'objet Flashbag
$flashModel = new Flashbag();

// Si le formulaire a correctement été soumis
if(!empty($_POST)) {

    // TODO: add strip_tags on forms
    // Récupération des données du formulaire
    $comment = strip_tags($_POST['comment']);
    $productId = intval($_POST['productId']);
    $rating = intval($_POST['starRate']);
    $title = strip_tags($_POST['title']);

    // Récupèration de l'id de l'utilisateur
    $userId = (new UserSession())->getUserId();

    // Vérification du formulaire de commentaire
    $errors = ValidateCommentForm($comment, $rating, $title);
    
    // Si il n'y a pas d'erreur, ajout du commentaire
    if (empty($errors)) {

        // Ajout du commentaire et ses informations dans la BDD
        (new CommentModel())->addComment($comment, $title, $productId, $rating, $userId);

        // Création d'un message flash
        $flashModel->addFlashMessage('Votre commentaire a bien été pris en compte.');
    }
    else {
        
        // Ajoute les erreurs dans un message flash
        foreach ($errors as $error) {
            $flashModel->addFlashMessage($error);
        }
    }

    // Redirection vers la page du produit
    header('Location: /product?productId='.$productId);
}
