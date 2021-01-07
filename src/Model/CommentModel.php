<?php

class CommentModel extends AbstractModel
{
    /* Récupère tous les commentaires d'un produit */
    public function getCommentsByProductId(int $id, bool $isValidated = true)
    {
        // Requête de sélection SQL
        $sql = 'SELECT content, comments.createdAt AS commentCreatedAt, title, rating, firstname AS authorFname, lastname AS authorLname
                FROM comments
                INNER JOIN users
                ON comments.user_id = users.id
                WHERE product_id = ? AND is_validated = ?
                ORDER BY `commentCreatedAt` DESC';

        return $this->database->selectAll($sql, [$id, $isValidated]);
    }

    /* Récupère tous les commentaires */
    public function getAllComments()
    {
        // Requête de sélection SQL
        $sql = 'SELECT comments.id AS commentId, 
                    content, 
                    comments.createdAt AS commentCreatedAt, 
                    title, 
                    rating, 
                    is_validated, 
                    firstname AS authorFname, 
                    lastname AS authorLname,
                    products.name AS productName
                FROM comments
                INNER JOIN users
                ON comments.user_id = users.id
                INNER JOIN products
                ON comments.product_id = products.id
                ORDER BY `commentCreatedAt` DESC';

        return $this->database->selectAll($sql);
    }

    /* Ajoute le commentaire et ses détails dans la BDD */
    public function addComment(string $comment, string $title, int $productId, int $rating, int $userId, bool $isValidated = false) {

        // Requête d'insertion SQL
        $sql = 'INSERT INTO comments (content, createdAt, product_id, title, rating, user_id, is_validated)
                VALUES (?, Now(), ?, ?, ?, ?, ?)';
        
        $this->database->prepareAndExecuteQuery($sql, [$comment, $productId, $title, $rating, $userId, $isValidated]);

    }

    /* Mets à jour la validation du commentaire */
    public function updateCommentValidation(int $commentId, bool $isValidated)
    {
        // Requête de mise à jour SQL
        $sql = 'UPDATE comments
                SET is_validated = ?
                WHERE comments.id = ?';

        $this->database->prepareAndExecuteQuery($sql, [$isValidated, $commentId]);
    }

    /* Supprime un commentaire */
    public function deleteComment(int $commentId)
    {
        // Requête de suppression SQL
        $sql = 'DELETE FROM comments
                WHERE id = ?';

        $this->database->prepareAndExecuteQuery($sql, [$commentId]);
    }
}