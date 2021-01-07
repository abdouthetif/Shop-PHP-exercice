<?php

/* Porte d'entrée unique pour toutes les pages */
use App\Core\Router;

// Inclusion des dépendances
require '../src/functions.php';
require '../autoload.php';


// Vérifie la route à afficher
(new Router())->getRoute();