<?php

// On stocke les informations de connexion dans des constantes
const DB_HOST = 'localhost';
const DB_NAME = 'shop';
const DB_USER = 'root';
const DB_PASSWORD = '';

if(!empty($_GET)) {

    $product = $_GET['prudctId'];

    $productDetails = getProduct($product);

}

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

// Récupération des données
function getProduct($product) {
    
    $pdo = getPDOConnection();
    
    /* requête de sélection des produits */
    // Requête SQL
    $sql = 'SELECT products.name, 
                   products.description, 
                   products.picture, 
                   products.price, 
                   products.stock, 
                   categories.label, 
                   creators.shop_name
    FROM products
    JOIN categories
    ON products.category_id = categories.id
    JOIN creators
    ON products.creator_id = creators.id
    WHERE products.id = ?';
    
    // Préparation de la requête SQL
    $query = $pdo->prepare($sql);
    
    // Exécution de la requête SQL
    $query->execute([$product]);
    
    // Récupération de TOUS les résultats d'un coup avec la méthode fetchAll()
    return $query->fetch();
}

/* inclusion du fichier de template */
include '../templates/product-details.phtml';