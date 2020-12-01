<?php

// Inclusion du fichier de configuration
require '../config.php';

/* Crée la connexion PDO */
function getPDOConnection() {
    
    // Construction du Data Source Name
    $dsn = 'mysql:dbname='.DB_NAME.';host='.DB_HOST;
    
    // Tableau d'options pour la connexion PDO
    $options = [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ];
    
    // Création de la connexion PDO (création d'un objet PDO)
    $pdo = new PDO($dsn, DB_USER, DB_PASSWORD, $options);
    $pdo->exec('SET NAMES UTF8');

    return $pdo;
}

/* Récupère tous les produits */
function getProducts() {
    
    // Connexion à la BDD
    $pdo = getPDOConnection();

    // Requête de sélection SQL
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
    
    // Récupération des résultats
    return $query->fetchAll();
}

/* Récupère les détails d'un produit */
function getProduct($product) {
    
    // Connexion à la BDD
    $pdo = getPDOConnection();
    
    // Requête de sélection SQL
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
    
    // Récupération des résultats
    return $query->fetch();
}