<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

class DevModel extends \Com\Daw2\Core\BaseModel {

    private const BASE = "SELECT * FROM devs ";

    function getAllDevs(): array {
        $stmt = $this->pdo->query(self::BASE . " ORDER BY devName ASC");
        return $stmt->fetchAll();
    }
    
    function checkDevExists($inputDevs) {
        $devs = $this->getAllDevs();

        foreach ($devs as $dev) {
            foreach ($inputDevs as $inputDev) {
                if($inputDev==$dev['devID']){
                    return true;
                }
            }
        }
        
        return false;
    }
    
    function getDevGamesById($id) {
        $query = $this->pdo->prepare("SELECT devID FROM devGames WHERE gameID = ?");
        $query->execute([$id]);
        return $query->fetchAll();
    }

}
