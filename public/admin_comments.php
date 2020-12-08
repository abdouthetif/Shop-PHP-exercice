<?php

// Inclusion des dépendances
require '../src/functions.php';

// Autorisation : l'utilisateur est-il connecté et a-t-il le rôle ADMIN ?
verifyAdmin();

// Récupération de tous les commentaires
$comments = getAllComments();

// Inclusion du fichier de template et ses variables
render('admin_comments', [
    'pageTitle' => 'Modération des commentaires', 
    'template_bg' => 'bg-light',
    'comments' => $comments
]);