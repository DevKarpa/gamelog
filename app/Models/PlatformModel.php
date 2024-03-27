<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

class PlatformModel extends \Com\Daw2\Core\BaseModel {

    private const BASE = "SELECT * FROM platforms ";

    function getAllPlatforms(): array {
        $stmt = $this->pdo->query(self::BASE . "ORDER BY platformName ASC");
        return $stmt->fetchAll();
    }
    
    function checkPlatformExists($platform): bool {
        $query = $this->pdo->prepare(self::BASE . "WHERE platformID = ?");
        $query->execute([$platform]);
        
        if(count($query->fetchAll())==0){
            return false;
        }
        
        return true;
    }

}