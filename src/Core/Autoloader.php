<?php 

namespace App\Core;

class Autoloader {

    // Enregistrement de la fonction autoload() en tant que fonction d'autoloading
    static public function register()
    {
        spl_autoload_register([__CLASS__, 'autoload']);
    }

    // PHP exécutera la fonction autoload() à chaque fois qu'il va chercher une classe inconnue
    static public function autoload($classname)
    {
        $path = str_replace('App', 'src', $classname);
        $path = str_replace('\\', '/', $path);

        if (file_exists('../' . $path . '.php')) {
            require '../' . $path . '.php';
        }
    }
}