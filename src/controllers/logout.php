<?php

use App\Service\Flashbag;
use App\Service\UserSession;

// Déconnexion utilisateur
$userSession = new UserSession();
$userSession->logout();

// Redirection vers la page d'accueil avec un message flash
$flashModel = new Flashbag();
$flashModel->addFlashMessage('Au revoir !');
header('Location: /');
exit;