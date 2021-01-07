<?php

class Router
{
    // Propriétés
    private $path;
    private $routes;

    // Constructeur
    public function __construct()
    {
        // Récupère le path, le chemin dans l'url après le domaine
        $this->path = $_SERVER['PATH_INFO'] ?? '/';

        // Routing
        $this->routes = [
            '/' => 'home.php',
            '/pictures' => 'pictures.php',
            '/product' => 'product-details.php',
            '/create-account' => 'create_account.php',
            '/comment/add' => 'add_comment.php',
            '/connexion/logout' => 'logout.php',
            '/connexion/login' => 'login.php',
            '/admin/product' => 'admin.php',
            '/admin/comment' => 'admin_comments.php',
            '/admin/product/new' => 'admin_add_product.php',
            '/admin/product/delete' => 'admin_delete_product.php',
            '/admin/product/edit' => 'admin_edit_product.php',
            '/admin/comment/delete' => 'admin_delete_comment.php',
            '/admin/comment/unvalidate' => 'admin_unvalidate_comment.php',
            '/admin/comment/validate' => 'admin_validate_comment.php',
            '/admin/product/category/delete' => 'admin_delete_category.php',
            '/admin/product/category/create-update' => 'admin_CreateUpdate_category.php',
            '/admin/product/creator/delete' => 'admin_delete_creator.php',
            '/admin/product/creator/create-update' => 'admin_CreateUpdate_creator.php'
        ];
    }

    /* Vérifie la route à afficher */
    public function getRoute()
    {
        // Vérifie l'existence du path dans le tableau de routes
        if (array_key_exists($this->path, $this->routes)) {

            // Vérifie si le path comporte 'admin'
            if (str_contains($this->path, 'admin')) {

                // Autorisation : l'utilisateur est-il connecté et a-t-il le rôle ADMIN ?
                if (!(new UserSession())->isAuthenticated() || $_SESSION['user']['role'] != ROLE_ADMIN) {
                    
                    // Erreur 403
                    http_response_code(403);

                    // Affiche le template
                    render('403', [
                        'pageTitle' =>'Erreur 403 : autorisation refusée'
                    ]);
                    exit;
                }
                else {
                    if (str_contains($this->path, 'delete')) {

                        // Vérifie l'existence de l'id du produit dans l'url
                        if (!array_key_exists('id', $_GET) || !isset($_GET['id']) || !ctype_digit($_GET['id'])) {
                            
                            // Erreur 404
                            http_response_code(404);

                            // Affiche le template
                            render('404', [
                                'pageTitle' => "Erreur 404 : l'id est inexistant"
                            ]);
                            exit;
                        }
                    }
                }
            }

            // Inclut le fichier php correspondant
            require '../src/controllers/' . $this->routes[$this->path];
        }
        else {

            // Erreur 404
            http_response_code(404);

            // Affiche le template
            render('404', [
                'pageTitle' =>'Erreur 404 : page non trouvée'
            ]);
            exit;
        }
    }
}