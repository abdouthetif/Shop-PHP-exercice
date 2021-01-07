<?php

// Espace de nom
namespace App\Model;

// Import des classes auxquels on fait référence
use App\Core\AbstractModel;

class ProductModel extends AbstractModel
{
    /* Récupère tous les produits */
    public function getAllProducts()
    {
        // Requête de sélection SQL
        $sql = 'SELECT products.id, 
                    products.name,
                    products.price, 
                    categories.label, 
                    creators.shop_name,
                    picture_1,
                    picture_2,
                    picture_3,
                    picture_4
                FROM products
                JOIN categories
                ON products.category_id = categories.id
                JOIN creators
                ON products.creator_id = creators.id
                JOIN pictures
                ON products.id = pictures.product_id
                ORDER BY products.id';

        return $this->database->selectAll($sql);
    }

    /* Récupère les détails d'un produit à partir de son id*/
    public function getProductById(int $id) 
    {    
        // Requête de sélection SQL
        $sql = 'SELECT products.id AS productId,
                    products.name, 
                    products.description,  
                    products.price, 
                    products.stock, 
                    products.category_id,
                    products.creator_id,
                    pictures.picture_1,
                    pictures.picture_2,
                    pictures.picture_3,
                    pictures.picture_4,
                    categories.label, 
                    creators.shop_name
                FROM products
                JOIN pictures
                ON products.id = pictures.product_id
                JOIN categories
                ON products.category_id = categories.id
                JOIN creators
                ON products.creator_id = creators.id
                WHERE products.id = ?';

        return $this->database->selectOne($sql, [$id]);
    }

    /* Ajoute un produit dans la BDD */
    public function insertProduct(string $name, string  $description, float $price, int $stock, int $categoryId, int $creatorId, string $pictureA, string $pictureB, string $pictureC, string $pictureD)
    {
        // Requête d'insertion SQL
        $sql = 'INSERT INTO products (name, description, price, stock, category_id, creator_id)
                VALUES (?, ?, ?, ?, ?, ?);
                INSERT INTO pictures (product_id, picture_1, picture_2, picture_3, picture_4)
                VALUES (LAST_INSERT_ID(), ?, ?, ?, ?)';

        $this->database->prepareAndExecuteQuery($sql, [$name, $description, $price, $stock, $categoryId, $creatorId, $pictureA, $pictureB, $pictureC, $pictureD]);
    }

    /* Mets à jour un produit dans la BDD */
    public function updateProduct(int $productId, string $name, string  $description, float $price, int $stock, int $categoryId, int $creatorId, string $pictureA, string $pictureB, string $pictureC, string $pictureD)
    {
        // Requête de mise à jour SQL
        $sql = 'UPDATE products
                INNER JOIN pictures
                ON products.id = pictures.product_id
                SET name = ?, description = ?, price = ?, stock = ?, category_id = ?, creator_id = ?, pictures.picture_1 = ?, pictures.picture_2 = ?, pictures.picture_3 = ?, pictures.picture_4 = ?
                WHERE products.id = ?';

        $this->database->prepareAndExecuteQuery($sql, [$name, $description, $price, $stock, $categoryId, $creatorId, $pictureA, $pictureB, $pictureC, $pictureD, $productId]);
    }

    /* Supprime un produit dans la BDD */
    public function removeProduct(int $productId)
    {
        // Requête de suppression SQL
        $sql = 'DELETE FROM products
                WHERE id = ?;
                DELETE FROM pictures
                WHERE product_id = ?';

        $this->database->prepareAndExecuteQuery($sql, [$productId, $productId]);
    }
}