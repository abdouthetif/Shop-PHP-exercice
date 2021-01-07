<?php

use App\Model\CommentModel;

// Récupération de tous les commentaires
$comments = (new CommentModel())->getAllComments();

// Inclusion du fichier de template et ses variables
render('admin_comments', [
    'pageTitle' => 'Modération des commentaires', 
    'template_bg' => 'bg-light',
    'comments' => $comments
]);