<?php 

class Autoloader {

    // Enregistrement de la fonction autoload() en tant que fonction d'autoloading
    static public function register()
    {
        spl_autoload_register([__CLASS__, 'autoload']);
    }

    // PHP exécutera la fonction autoload() à chaque fois qu'il va chercher une classe inconnue
    static public function autoload($classname)
    {
        if (file_exists('../src/Core/' . $classname . '.php')) {
            require '../src/Core/' . $classname . '.php';
        }
        else if (file_exists('../src/Model/' . $classname . '.php')) {
            require '../src/Model/' . $classname . '.php';
        }
        else if (file_exists('../src/Service/' . $classname . '.php')) {
            require '../src/Service/' . $classname . '.php';
        }
    }
}