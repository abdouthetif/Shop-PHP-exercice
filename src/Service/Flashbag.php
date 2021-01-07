<?php

/******************************
 * GESTION DES MESSAGES FLASH
 ******************************/

namespace App\Service;

class Flashbag
{
    // Constructeur
    public function __construct()
    {
        // Initialisation du flashbag
        $this->initFlashbag();
    }

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
        // On ajoute dans le tableau de message le message passé en paramètre
        // $_SESSION['flashbag'][] = $message;
        array_push($_SESSION['flashbag'], $message);
    }

    /* Récupère et retourne l'ensemble des messages flash de la session */
    function fetchAllFlashMessages(): array 
    {
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
        // Retourne true si il y a des messages dans le tableau, false sinon
        return !empty($_SESSION['flashbag']);
    }
}