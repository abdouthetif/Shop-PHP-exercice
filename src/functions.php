<?php

// Inclusion du fichier de configuration
require '../config.php';
require '../vendor/autoload.php';

/* Crée la connexion PDO */
function getPDOConnection()
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
function prepareAndExecuteQuery(string $sql, array $criteria = []): PDOStatement
{
    // Connexion PDO
    $pdo = getPDOConnection();

    // Préparation de la requête SQL
    $query = $pdo->prepare($sql);

    // Exécution de la requête
    $query->execute($criteria);

    return $query;
}

/* Exécute une requête de sélection et retourne plusieurs résultats */
function selectAll(string $sql, array $criteria = [])
{
    // Prépare et exécute une requête SQL
    $query = prepareAndExecuteQuery($sql, $criteria);

    return $query->fetchAll();
}

/* Exécute une requête de sélection et retourne un résultat */
function selectOne(string $sql, array $criteria = [])
{
    // Prépare et exécute une requête SQL
    $query = prepareAndExecuteQuery($sql, $criteria);

    return $query->fetch();
}

/* Récupère tous les produits */
function getAllProducts()
{
    // Requête de sélection SQL
    $sql = 'SELECT products.id, 
                   products.name, 
                   products.picture, 
                   products.price, 
                   categories.label, 
                   creators.shop_name
            FROM products
            JOIN categories
            ON products.category_id = categories.id
            JOIN creators
            ON products.creator_id = creators.id
            ORDER BY products.id';

    return selectAll($sql);
}

/* Récupère les détails d'un produit à partir de son id*/
function getProductById(int $id) 
{    
    // Requête de sélection SQL
    $sql = 'SELECT products.id AS productId,
                   products.name, 
                   products.description,  
                   products.price, 
                   products.stock, 
                   products.category_id,
                   products.creator_id,
                   pictures.picture_1,
                   pictures.picture_2,
                   pictures.picture_3,
                   pictures.picture_4,
                   categories.label, 
                   creators.shop_name
            FROM products
            JOIN pictures
            ON products.id = pictures.product_id
            JOIN categories
            ON products.category_id = categories.id
            JOIN creators
            ON products.creator_id = creators.id
            WHERE products.id = ?';
    
    return selectOne($sql, [$id]);
}

/* Récupère tous les commentaires pour chaque produit */
function getCommentsByProductId(int $id, bool $isValidated = true)
{
    // Requête de sélection SQL
    $sql = 'SELECT content, comments.createdAt AS commentCreatedAt, title, rating, firstname AS authorFname, lastname AS authorLname
            FROM comments
            INNER JOIN users
            ON comments.user_id = users.id
            WHERE product_id = ? AND is_validated = ?
            ORDER BY `commentCreatedAt` DESC';

    return selectAll($sql, [$id, $isValidated]);
}

/* Récupère tous les commentaires */
function getAllComments()
{
    // Requête de sélection SQL
    $sql = 'SELECT comments.id AS commentId, 
                   content, 
                   comments.createdAt AS commentCreatedAt, 
                   title, 
                   rating, 
                   is_validated, 
                   firstname AS authorFname, 
                   lastname AS authorLname,
                   products.name AS productName
            FROM comments
            INNER JOIN users
            ON comments.user_id = users.id
            INNER JOIN products
            ON comments.product_id = products.id
            ORDER BY `commentCreatedAt` DESC';

    return selectAll($sql);
}

function getAllCategories()
{
    // Requête de sélection SQL
    $sql = 'SELECT id, label
            FROM categories
            ORDER BY label';
    
    return selectAll($sql);
}

function getAllCreators()
{
    // Requête de sélection SQL
    $sql = 'SELECT id, shop_name
            FROM creators
            ORDER BY shop_name';
    
    return selectAll($sql);
}

/* Ajoute le commentaire et ses détails dans la BDD */
function addComment(string $comment, string $title, int $productId, int $rating, int $userId, bool $isValidated = false) {

    // Requête SQL
    $sql = 'INSERT INTO comments (content, createdAt, product_id, title, rating, user_id, is_validated)
            VALUES (?, Now(), ?, ?, ?, ?, ?)';
            
    prepareAndExecuteQuery($sql, [$comment, $productId, $title, $rating, $userId, $isValidated]);

}

/* Ajoute un utilisateur à la BDD */
function addUser(string $firstname, string $lastname, string $email, string $password, string $role)
{
    // Requête SQL
    $sql = 'INSERT INTO users (firstname, lastname, email, password, createdAt, role)
            VALUES (?, ?, ?, ?, NOW(), ?)';

    // Hashage du mot de passe 
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            
    prepareAndExecuteQuery($sql, [$firstname, $lastname, $email, $hashedPassword, $role]);
}

function insertProduct(string $name, string  $description, float $price, int $stock, int $categoryId, int $creatorId, string $picture)
{
    $sql = 'INSERT INTO products (name, description, price, stock, category_id, creator_id)
            VALUES (?, ?, ?, ?, ?, ?);
            INSERT INTO pictures (product_id, picture_1)
            VALUES (LAST_INSERT_ID(), ?)';

    prepareAndExecuteQuery($sql, [$name, $description, $price, $stock, $categoryId, $creatorId, $picture]);
}

function updateProduct(int $productId, string $name, string  $description, float $price, int $stock, int $categoryId, int $creatorId, string $picture)
{
    $sql = 'UPDATE products
            INNER JOIN pictures
            ON products.id = pictures.product_id
            SET name = ?, description = ?, price = ?, stock = ?, category_id = ?, creator_id = ?, pictures.picture_1 = ?
            WHERE products.id = ?';

    prepareAndExecuteQuery($sql, [$name, $description, $price, $stock, $categoryId, $creatorId, $picture, $productId]);
}

function updateCommentValidation(int $commentId, bool $isValidated)
{
    $sql = 'UPDATE comments
            SET is_validated = ?
            WHERE comments.id = ?';

    prepareAndExecuteQuery($sql, [$isValidated, $commentId]);
}

function deleteComment(int $commentId)
{
    $sql = 'DELETE FROM comments
            WHERE id = ?';

    prepareAndExecuteQuery($sql, [$commentId]);
}

function removeProduct(int $productId)
{
    $sql = 'DELETE FROM products
            WHERE id = ?';

    prepareAndExecuteQuery($sql, [$productId]);
}

/* Sélectionne un utilisateur à partir de son email */
function getUserByEmail(string $email) 
{
    $sql = 'SELECT id, firstname, lastname, email, password, role 
            FROM users
            WHERE email = ?';

    return selectOne($sql, [$email]);
}

function validateFirstname(string $firstname) 
{
    $errors = "";

    // Vérifie si le champ est vide
    if (!isset($firstname) || empty($firstname)) {
        $errors = 'Le champ "Prénom" est obligatoire';
    }

    // Vérifie si le firstname est trop court
    else if (iconv_strlen($firstname) < 5) {
        $errors = 'Le champ "Prénom" est trop court';
    }

    // Vérifie si le firstname est trop long
    else if (iconv_strlen($firstname) > 15) {
        $errors = 'Le champ "Prénom" est trop long';
    }

    return $errors;
}

function validateLastname(string $lastname) 
{
    $errors = "";
    
    // Vérifie si le champ est vide
    if (!isset($lastname) || empty($lastname)) {
        $errors = 'Le champ "Nom" est obligatoire';
    }

    // Vérifie si le firstname est trop court
    else if (iconv_strlen($lastname) < 5) {
        $errors = 'Le champ "Nom" est trop court';
    }

    // Vérifie si le firstname est trop long
    else if (iconv_strlen($lastname) > 15) {
        $errors = 'Le champ "Nom" est trop long';
    }

    return $errors;
}

function validateEmail(string $email) 
{
    $errors = "";
    
    // Vérifie si le champ est vide
    if (!isset($email) || empty($email)) {
        $errors = 'Le champ "Email" est obligatoire';
    }

    // Vérifie le format de l'email
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors = "Ce n'est pas une adresse email valide.";
    }

    // Vérifie l'existance de l'email dans la BD
    else if (getUserByEmail($email)) {
        $errors = "Cette adresse email existe déjà.";
    }

    return $errors;
}

function validatePassword(string $password, string $passwordConfirm) 
{
    $errors = '';
    
    // Vérifie la fiabilité du mot de passe
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number    = preg_match('@[0-9]@', $password);
    $specialChars = preg_match('@[^\w]@', $password);

    // Vérifie si le champ password est vide
    if (!isset($password) || empty($password)) {
        $errors = 'Le champ "Mot de passe" est obligatoire';
    }

    // Vérifie si le mot de passe a 1 majuscule
    else if(!$uppercase) {
        $errors = 'Le mot de passe doit comporter une lettre majuscule ou plus';
    }

    // Vérifie si le mot de passe a 1 minuscule
    else if (!$lowercase) {
        $errors = 'Le mot de passe doit comporter une lettre minuscule ou plus';
    }

    // Vérifie si le mot de passe a 1 chiffre
    else if (!$number) {
        $errors = 'Le mot de passe doit comporter un chiffre ou plus';
    }

    // Vérifie si le mot de passe a 1 caractère spécial
    else if (!$specialChars) {
        $errors = 'Le mot de passe doit comporter un caractère spécial ou plus';
    }

    // Vérifie si le mot de passe est supérieur à 8 caractères
    else if (mb_strlen($password) < 8) {
        $errors = 'Le mot de passe doit comporter 8 caractère ou plus';
    }

    // Vérifie si le champ passwordConfirm est vide
    else if (!isset($passwordConfirm) || empty($passwordConfirm)) {
        $errors = 'Le champ "Confirmation du mot de passe" est obligatoire';
    }

    // Vérifie si le mot de passe est identique à la confirmation
    else if ($password != $passwordConfirm) {
        $errors = 'La confirmation du mot de passe ne correspond pas au mot de passe';
    }

    return $errors;
}

function validateUserForm(string $firstname, string $lastname, string $email, string $password, string $passwordConfirm)
{
    $errors = [];
    
    // Stock les messages d'erreurs dans un tableau
    if (!empty(validateFirstname($firstname))) {

        $errors[] = validateFirstname($firstname);
    }
    else if (!empty(validateLastname($lastname))) {

        $errors[] = validateLastname($lastname);
    }
    else if (!empty(validateEmail($email))) {

        $errors[] = validateEmail($email);
    }
    else if (!empty(validatePassword($password, $passwordConfirm))) {

        $errors[] = validatePassword($password, $passwordConfirm);
    }

    return $errors;
}

function validateLoginForm(string $email, string $password): array
{
    $errors = [];
    
    if (!$email) {
        $errors[] = 'Le champ "Email" est obligatoire.';
    }

    if (!$password) {
        $errors[] = 'Le champ "Mot de passe" est obligatoire.';
    }

    return $errors;
}

function validateProductForm($name, $description, $price, $stock)
{
    $errors = [];

    if (!$name) {
        $errors[] = 'Le nom du produit est obligatoire';
    }

    if (!$description) {
        $errors[] = 'La description du produit est obligatoire';
    }

    if (!$price) {
        $errors[] = 'Le prix du produit est obligatoire';
    }
    else if (!is_numeric($price) || $price < 0) {
        $errors[] = 'La valeur du prix est incorrecte';
    }

    if (!$stock) {
        $errors[] = 'Le stock du produit est obligatoire';
    }
    else if (!ctype_digit($stock) || $stock < 0) {
        $errors[] = 'La valeur du stock est incorrecte';
    }
    
    return $errors;
}

function verifyPassword(array $user, string $password)
{
    /**
     * $user['password'] : mot de passe enregistré en base de données
     * $password : mot de passe rentré par l'utilisateur dans le formulaire de connexion
     */
    return password_verify($password, $user['password']);
}


function authenticate(string $email, string $password)
{
    // On va chercher l'utilisateur en fonction de son email
    $user = getUserByEmail($email);

    // Si on récupère bien un résultat (un utilisateur)
    if ($user) {

        // Vérification du mot de passe
        if (verifyPassword($user, $password)) {

            // On retourne les informations de l'utilisateur
            return $user;
        }
        else {
            return "Mot de passe incorrect";
        }
    }
    else {
       return "Ce compte n'existe pas"; 
    }
}

/**
 * Initialise la session si besoin
 */
function initSession()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

/**
 * Enregistre les données de l'utilisateur connecté en session
 */
function userSessionRegister(int $id, string $firstname, string $lastname, string $email, string $role)
{
    initSession();

    $_SESSION['user'] = [
        'id' => $id,
        'firstname' => $firstname,
        'lastname' => $lastname,
        'email' => $email,
        'role' => $role
    ];
}

/**
 * Vérifie si l'utilisateur est connecté
 */
function isAuthenticated(): bool
{
    initSession();

    return array_key_exists('user', $_SESSION) && isset($_SESSION['user']);
}

/**
 * Déconnexion utilisateur
 */
function logout()
{
    if (isAuthenticated()) {

        // On efface les données qu'on avait enregistrées
        $_SESSION['user'] = null; // ou bien : unset($_SESSION['user])
        
        // On ferme la session
        session_destroy();
    }
}

/**
 * Formate un prix à la française xx,xx €
 */
function format_price(float $price): string 
{
    // return number_format($price, 2, ',', ' ') . ' €';
    $formatter = new NumberFormatter('fr_FR', NumberFormatter::CURRENCY);
    return $formatter->formatCurrency($price, 'EUR');
}

/* Change le format de la date */
function format_date($date)
{
    $objDate = new DateTime($date);
    return $objDate->format('d/m/Y');
}

/* Inclut le template de base et ses variables */
function render(string $template, array $values = [], string $baseTemplate = 'base')
{
    // Extraction des variables
    extract($values);

    // Affichage des messages flash
    $flashMessages = fetchAllFlashMessages();

    /* Inclusion du template de base */
    include '../templates/'.$baseTemplate.'.phtml';
}

/******************************
 * GESTION DES MESSAGES FLASH
 ******************************/

/**
 * Démarre la session (le cas échéant, si aucune session n'est déjà démarrée)
 * Initialise un tableau vide à la clé 'flashbag' si jamais la clé n'existe pas 
 * ou si elle ne contient pas de tableau
 */
function initFlashbag()
{
    // Si aucune session n'est encore démarrée ...
    if (session_status() === PHP_SESSION_NONE) {

        // ... alors on en démarre une
        session_start();
    } 

    // Si la clé 'flashbag' n'existe pas en session ou si elle n'est pas définie... 
    if (!array_key_exists('flashbag', $_SESSION) || !isset($_SESSION['flashbag'])) {

        // ... alors on range dans la clé 'flashbag' un tableau vide
        $_SESSION['flashbag'] = [];
    }
}

/* Ajoute un message flash au flashbag en session */
function addFlashMessage(string $message)
{
    // Initialisation du flashbag
    initFlashbag();

    // On ajoute dans le tableau de message le message passé en paramètre
    // $_SESSION['flashbag'][] = $message;
    array_push($_SESSION['flashbag'], $message);
}

/* Récupère et retourne l'ensemble des messages flash de la session */
function fetchAllFlashMessages(): array 
{
    // Initialisation du flashbag
    initFlashbag();

    // On récupère tous les messages 
    $FlashMessages = $_SESSION['flashbag'];

    // On supprime les messages de la session
    $_SESSION['flashbag'] = [];

    // On retourne le tableau de messages
    return $FlashMessages;
}

/* Détermine si il y a des messages flash en session */
function hasFlashMessages(): bool
{
    // Initialisation du flashbag
    initFlashbag();

    // Retourne true si il y a des messages dans le tableau, false sinon
    return !empty($_SESSION['flashbag']);
}

function getUserFullname(): string
{
    if (!isAuthenticated()) {
        return null;
    }

    // S'il est connecté
    return $_SESSION['user']['firstname'] . ' ' . $_SESSION['user']['lastname'];
}

function getUserId(): ?int 
{
    if (!isAuthenticated()) {
        return null;
    }

    return $_SESSION['user']['id'];
}

function verifyAdmin()
{
    // Autorisation : l'utilisateur est-il connecté et a-t-il le rôle ADMIN ?
    if (!isAuthenticated() || $_SESSION['user']['role'] != ROLE_ADMIN) {
        http_response_code(403);
        echo "Vous n'êtes pas autorisé à accéder à cette page.";
        exit;
    }
}