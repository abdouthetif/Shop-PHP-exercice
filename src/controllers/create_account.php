<?php

// Initialisation
$errors = null;
$firstname = null;
$lastname = null;
$email = null;
$userModel = new UserModel();
$flashModel = new Flashbag();

// Si le formulaire a correctement été soumis
if(!empty($_POST)) {

    // Récupération des données du formulaire
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordConfirm = $_POST['confirmpass'];
    $errors = [];
    
    // Validation du formulaire
    $errors = validateUserForm($firstname, $lastname, $email, $password, $passwordConfirm);
    
    // Si il n'y a pas d'erreur on ajoute l'email
    if (empty($errors)) {

        // Ajout de l'email dans la BDD
        $userModel->addUser($firstname, $lastname, $email, $password, ROLE_USER);

        $flashModel->addFlashMessage("Votre compte a bien été créé !");

        // Redirection vers la page de succès
        header('Location: /');

        // Arrête le script php
        exit;
    }
}

// Inclusion du fichier de template et ses variables
render('create_account', [
    'pageTitle' => 'Créez un compte ou connectez vous', 
    'template_bg' => 'bg-light',
    'errors' => $errors,
    'firstname' => $firstname,
    'lastname' => $lastname,
    'email' => $email
]);