<?php

/**Pour les produits sur la page d'accueil on va afficher : 
 * Objectif : afficher sous forme de résumés la liste des produits
 *  - Nom du produit
 *  - Image principale
 *  - Prix
 *  - Intitulé de la catégorie
 *  - Nom de la boutique du créateur
*/

/* connexion à la BDD avec PDO */
// On stocke les informations de connexion dans des constantes
const DB_HOST = 'localhost';
const DB_NAME = 'shop';
const DB_USER = 'root';
const DB_PASSWORD = '';

/* connexion à la BDD avec PDO */
function getPDOConnection() {
    
    // Construction du Data Source Name
    $dsn = 'mysql:dbname='.DB_NAME.';host='.DB_HOST;
    
    // Tableau d'options pour la connexion PDO
    $options = [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ];
    
    // Création de la connexion PDO (création d'un objet PDO)
    return new PDO($dsn, DB_USER, DB_PASSWORD, $options);
}

function getProduct() {
    
    $pdo = getPDOConnection();

    /* requête de sélection des produits */
    // Requête SQL
    $sql = 'SELECT products.id, products.name, products.picture, products.price, categories.label, creators.shop_name
    FROM products
    JOIN categories
    ON products.category_id = categories.id
    JOIN creators
    ON products.creator_id = creators.id';
    
    // Préparation de la requête SQL
    $query = $pdo->prepare($sql);
    
    // Exécution de la requête SQL
    $query->execute();
    
    // Récupération de TOUS les résultats d'un coup avec la méthode fetchAll()
    return $query->fetchAll();
}

$products = getProduct();

/* inclusion du fichier de template */
include '../templates/index.phtml';