<?php

// Récupère l'id de la catégorie
$categoryId = $_GET['id'];

// Supprime la categorie
(new CategoryModel())->deleteCategory($categoryId);

// Ajout d'un message flash et redirection vers le dashboard produit
(new Flashbag())->addFlashMessage('La catégorie a correctement été supprimée.');
header('Location: /admin/product?category');
exit;