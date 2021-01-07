<?php

namespace App\Service;

use App\Model\UserModel;

class Authenticator
{
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
        $userModel = new UserModel();
        $user = $userModel->getUserByEmail($email);

        // Si on récupère bien un résultat (un utilisateur)
        if ($user) {

            // Vérification du mot de passe
            if ($this->verifyPassword($user, $password)) {

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
}