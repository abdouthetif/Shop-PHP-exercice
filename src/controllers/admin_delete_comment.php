<?php

// Récupère l'id du commentaire
$commentId = $_GET['id'];

// Supprime le commentaire
(new CommentModel())->deleteComment($commentId);

// Ajout d'un message flash et redirection vers le dashboard commentaire
(new Flashbag())->addFlashMessage('Le commentaire a correctement été supprimé.');
header('Location: /admin/comment');
exit;