<?php

// Récupère l'id du produit
$productId = $_GET['id'];

// Supprime le produit
(new ProductModel())->removeProduct($productId);

// Ajout d'un message flash et redirection vers le dashboard produit
(new Flashbag())->addFlashMessage('Le produit est maintenant supprimé.');
header('Location: /admin/product');
exit;
