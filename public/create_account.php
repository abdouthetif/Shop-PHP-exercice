<?php
session_start();
// Inclusion des dépendances
require '../src/functions.php';

// Initialisation
$errors = null;
$firstname = null;
$lastname = null;
$email = null;

if(!empty($_POST)) {

    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordConfirm = $_POST['confirmpass'];
    $errors = [];
    
    // Validation du formulaire
    $errors = validateUserForm($firstname, $lastname, $email, $password, $passwordConfirm);
    dump($errors);
    // Si il n'y a pas d'erreur on ajoute l'email
    if (empty($errors)) {

        // Ajout de l'email dans le fichier csv
        addUser($firstname, $lastname, $email, $password);

        addFlashMessage("Votre compte a bien été créé !");

        // Redirection vers la page de succès
        header('Location: index.php');

        // Arrête le script php
        exit;
    }
}

// Inclusion du fichier de template et ses variables
$pageTitle = 'Créez un compte ou connectez vous';
$template_bg = 'bg-light';
render('create_account', [
    'pageTitle' => $pageTitle, 
    'template_bg' => $template_bg,
    'errors' => $errors,
    'firstname' => $firstname,
    'lastname' => $lastname,
    'email' => $email
]);