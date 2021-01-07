<?php

use App\Service\Flashbag;
use App\Model\CreatorModel;

// Récupère l'id du créateur
$creatorId = $_GET['id'];

// Supprime le créateur
(new CreatorModel())->deleteCreator($creatorId);

// Ajout d'un message flash et redirection vers le dashboard produit
(new Flashbag())->addFlashMessage('Le créateur a correctement été supprimée.');
header('Location: /admin/product?creator');
exit;