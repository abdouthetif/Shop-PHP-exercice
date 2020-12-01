<?php

// Inclusion des dépendances
require '../src/functions.php';

// Récupération de tous les produits
$products = getProducts();

/* Inclusion du fichier de template */
$pageTitle = 'Welcome to my shop!';
$template = 'index';
$template_bg = 'bg-dark';
include '../templates/base.phtml';