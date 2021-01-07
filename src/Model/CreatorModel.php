<?php

namespace App\Model;

use App\Core\AbstractModel;

class CreatorModel extends AbstractModel
{
    /* Récupère tous les créateurs */
    public function getAllCreators()
    {
        // Requête de sélection SQL
        $sql = 'SELECT id, shop_name
                FROM creators
                ORDER BY id';
    
        return $this->database->selectAll($sql);
    }

    /* Récupère un créateur selon l'id */
    public function getCreatorById(int $id)
    {
        // Requête de sélection SQL
        $sql = 'SELECT id, shop_name
                FROM creators
                WHERE id = ?
                ORDER BY id';

        return $this->database->selectOne($sql, [$id]);
    }

    /* Supprime un créateur de la BDD */
    public function deleteCreator(int $creatorId)
    {
        // Requête de suppression SQL
        $sql = 'DELETE FROM creators
                WHERE id = ?';

        $this->database->prepareAndExecuteQuery($sql, [$creatorId]);
    }

    /* Mets à jour un créateur dans la BDD */
    public function updateCreator(int $creatorId, string $creatorName)
    {
        // Requête de mise à jour SQL
        $sql = 'UPDATE creators
                SET shop_name = ?
                WHERE id = ?';

        $this->database->prepareAndExecuteQuery($sql, [$creatorName, $creatorId]);
    }

    /* Ajoute un créateur dans la BDD */
    public function addCreator(string $creatorName)
    {
        // Requête d'insertion SQL
        $sql = 'INSERT INTO creators (shop_name)
                VALUES (?)';

        $this->database->prepareAndExecuteQuery($sql, [$creatorName]);
    }

    /* Vérifie s'il faut ajouter ou mettre à jour une catégorie */
    public function addUpdateCreator(int $creatorId, string $creatorName)
    {
        // Vérifie si le nom de la catégorie est renseigné
        if (!$creatorName) {
            $this->flashBag->addFlashMessage("Erreur : Vous n'avez pas renseigné le nom du créateur");
        }
        
        // Vérifie si l'id existe
        else if (!empty($creatorId)) {
            $this->updateCreator($creatorId, $creatorName);
            $this->flashBag->addFlashMessage("Le créateur a correctement été mis à jour.");
        }

        // Sinon ajoute la catégorie
        else {
            $this->addCreator($creatorName);
            $this->flashBag->addFlashMessage("La créateur a correctement été créé.");   
        }

        // Redirection vers la page des produits de l'admin
        header('Location: /admin/product?creator');
        exit;
    }
}