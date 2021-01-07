<?php

class Database
{
    // Propriétés
    private $pdo;

    // Constructeur
    public function __construct()
    {
        $this->pdo = $this->getPDOConnection();
    }

    /* Crée la connexion PDO */
    public function getPDOConnection()
    {    
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

    /* Prépare et exécute une requête SQL */
    public function prepareAndExecuteQuery(string $sql, array $criteria = []): PDOStatement
    {
        // Préparation de la requête SQL
        $query = $this->pdo->prepare($sql);

        // Exécution de la requête
        $query->execute($criteria);

        return $query;
    }

    /* Exécute une requête de sélection et retourne plusieurs résultats */
    public function selectAll(string $sql, array $criteria = [])
    {
        // Prépare et exécute une requête SQL
        $query = $this->prepareAndExecuteQuery($sql, $criteria);

        return $query->fetchAll();
    }

    /* Exécute une requête de sélection et retourne un résultat */
    public function selectOne(string $sql, array $criteria = [])
    {
        // Prépare et exécute une requête SQL
        $query = $this->prepareAndExecuteQuery($sql, $criteria);

        return $query->fetch();
    }
}