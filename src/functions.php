<?php

// Inclusion du fichier de configuration
require '../config_exemple.php';
require '../vendor/autoload.php';

function validateFirstname(string $firstname) 
{
    $errors = "";

    // Vérifie si le champ est vide
    if (!isset($firstname) || empty($firstname)) {
        $errors = 'Le champ "Prénom" est obligatoire';
    }

    // Vérifie si le firstname est trop court
    else if (iconv_strlen($firstname) < 4) {
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
    else if (iconv_strlen($lastname) < 4) {
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
    $userModel = new \App\Model\UserModel();
    
    // Vérifie si le champ est vide
    if (!isset($email) || empty($email)) {
        $errors = 'Le champ "Email" est obligatoire';
    }

    // Vérifie le format de l'email
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors = "Ce n'est pas une adresse email valide.";
    }

    // Vérifie l'existance de l'email dans la BD
    else if ($userModel->getUserByEmail($email)) {
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

function ValidateCommentForm($comment, $rating, $title)
{
    $errors = [];

    if (empty($comment)) {
        $errors[] = 'Erreur : Le commentaire est vide.';
    }
    if (empty($rating)) {
        $errors[] = "Erreur : Vous n'avez pas attribué de notes.";
    }
    if (empty($title)) {
        $errors[] = "Erreur : Vous n'avez pas renseigné le titre.";
    }

    return $errors;
}

/* Inclut le template de base et ses variables */
function render(string $template, array $values = [], string $baseTemplate = 'base')
{
    // Extraction des variables
    extract($values);

    // Affichage des messages flash
    $flashModel = new \App\Service\Flashbag();
    $flashMessages = $flashModel->fetchAllFlashMessages();

    /* Inclusion du template de base */
    include '../templates/'.$baseTemplate.'.phtml';
}