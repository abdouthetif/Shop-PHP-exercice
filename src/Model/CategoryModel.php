<?php

namespace App\Model;

use App\Core\AbstractModel;

class CategoryModel extends AbstractModel
{
    /* Récupère toutes les catégories */
    public function getAllCategories()
    {
        // Requête de sélection SQL
        $sql = 'SELECT id, label
                FROM categories
                ORDER BY id';

        return $this->database->selectAll($sql);
    }

    /* Récupère une catégorie selon l'id */
    public function getCategoryById(int $id)
    {
        // Requête de sélection SQL
        $sql = 'SELECT id, label
                FROM categories
                WHERE id = ?
                ORDER BY id';

        return $this->database->selectOne($sql, [$id]);
    }

    /* Supprime une categorie de la BDD */
    public function deleteCategory(int $categoryId)
    {
        // Requête de suppression SQL
        $sql = 'DELETE FROM categories
                WHERE id = ?';

        $this->database->prepareAndExecuteQuery($sql, [$categoryId]);
    }

    /* Mets à jour une categorie dans la BDD */
    public function updateCategory(int $categoryId, string $categoryName)
    {
        // Requête de mise à jour SQL
        $sql = 'UPDATE categories
                SET label = ?
                WHERE id = ?';

        $this->database->prepareAndExecuteQuery($sql, [$categoryName, $categoryId]);
    }

    /* Ajoute un produit dans la BDD */
    public function addCategory(string $categoryName)
    {
        // Requête d'insertion SQL
        $sql = 'INSERT INTO categories (label)
                VALUES (?)';

        $this->database->prepareAndExecuteQuery($sql, [$categoryName]);
    }

    /* Vérifie s'il faut ajouter ou mettre à jour une catégorie */
    public function addUpdateCategory(int $categoryId, string $categoryName)
    {
        // Vérifie si le nom de la catégorie est renseigné
        if (!$categoryName) {
            $this->flashBag->addFlashMessage("Erreur : Vous n'avez pas renseigné le nom de la catégorie");
        }
        
        // Vérifie si l'id existe
        else if (!empty($categoryId)) {
            $this->updateCategory($categoryId, $categoryName);
            $this->flashBag->addFlashMessage("La catégorie a correctement été mis à jour.");
        }

        // Sinon ajoute la catégorie
        else {
            $this->addCategory($categoryName);
            $this->flashBag->addFlashMessage("La catégorie a correctement été créée.");   
        }

        // Redirection vers la page des produits de l'admin
        header('Location: /admin/product?category');
        exit;
    }
}