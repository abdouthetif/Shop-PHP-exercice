<?php

class UserModel extends AbstractModel
{
    /* Ajoute un utilisateur à la BDD */
    function addUser(string $firstname, string $lastname, string $email, string $password, string $role)
    {
        // Requête d'insertion SQL
        $sql = 'INSERT INTO users (firstname, lastname, email, password, createdAt, role)
                VALUES (?, ?, ?, ?, NOW(), ?)';

        // Hashage du mot de passe 
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        $this->database->prepareAndExecuteQuery($sql, [$firstname, $lastname, $email, $hashedPassword, $role]);
    }

    /* Sélectionne un utilisateur à partir de son email */
    function getUserByEmail(string $email) 
    {
        // Requête de sélection SQL
        $sql = 'SELECT id, firstname, lastname, email, password, role 
                FROM users
                WHERE email = ?';

        return $this->database->selectOne($sql, [$email]);
    }
}