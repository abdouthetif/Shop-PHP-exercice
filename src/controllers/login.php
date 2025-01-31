<?php

use App\Service\Flashbag;
use App\Service\UserSession;
use App\Service\Authenticator;

// Initialisations
$errorsLogin = null;
$flashModel = new Flashbag();
$userSession = new UserSession();

// Si le formulaire a été soumis ... 
if (!empty($_POST)) {

    // Récupérer les données du formulaire
    $email = $_POST['email'];
    $password = $_POST['password'];

    /**
     * Validation du formulaire : 
     *   - Est-ce que les champs email et mot de passe sont bien remplis ?
     */
    $errorsLogin = validateLoginForm($email, $password);    

    // Si la validation est OK (pas d'erreurs)
    if (empty($errorsLogin)) {

        /**
         * Authentification : 
         *    1°) Est-ce que l'email existe bien dans la table users ?
         *    2°) Est-ce que le mot de passe est correct ?
         */
        $authenticator = new Authenticator();
        $result = $authenticator->authenticate($email, $password);   
        
        // Si tout est OK (pas d'erreur)
        if (is_array($result)) {

            // Enregistrement de l'utilisateur en session
            $userSession->userSessionRegister(
                $result['id'],
                $result['firstname'],
                $result['lastname'],
                $result['email'],
                $result['role']
            );

            // Redirection vers la page d'accueil avec un message flash de confirmation
            $flashModel->addFlashMessage('Bonjour ' . $result['firstname'] . ' !');
            header('Location: /');
            exit;
        }
        else {
            $errorsLogin[] = $result;
        }
    }            
}

// Affichage du formulaire de connexion avec la fonction render()
render('create_account', [
    'pageTitle' => 'Créez un compte ou connectez vous', 
    'template_bg' => 'bg-light',
    'errorsLogin' => $errorsLogin
]);