<?php

declare(strict_types=1);

namespace Com\Gamelog\Models;

class UserConectionsModel extends \Com\Gamelog\Core\BaseModel {

    function createNewRegister($id): void {
        $query = $this->pdo->prepare("INSERT INTO userConections (userID) VALUES (?)");
        $query->execute([$id]);
    }

    // Obtiene todas las conexiones de un usuario
    function getAllConectionsFromUserID($id): array {
        $query = $this->pdo->prepare("SELECT twitter,steam,xbox,playstation,nintendo FROM userConections WHERE userID = ?");
        $query->execute([$id]);
        return $query->fetch();
    }

    function updateRegisterFromUserID($id, $con): void {
        $query = $this->pdo->prepare("UPDATE userConections SET twitter = ?, steam = ?, xbox = ?, playstation = ?, nintendo = ? WHERE userID = ?");
        $query->execute([empty($con['twitter']) ? null : $con['twitter'], 
            empty($con['steam']) ? null : $con['steam'], 
            empty($con['xbox']) ? null : $con['xbox'], 
            empty($con['playstation']) ? null : $con['playstation'], 
            empty($con['nintendo']) ? null : $con['nintendo'], 
            $id]);
    }

    function deleteRegister($id): void {
        $query = $this->pdo->prepare("DELETE FROM userConections WHERE userID = ?");
        $query->execute([$id]);
    }
    
}
