<?php

declare(strict_types=1);

namespace Com\Gamelog\Models;

class PlatformModel extends \Com\Gamelog\Core\BaseModel {

    private const BASE = "SELECT * FROM platforms ";

    // Obtiene todas las plataformas
    function getAllPlatforms(): array {
        $stmt = $this->pdo->query(self::BASE . "ORDER BY platformName ASC");
        return $stmt->fetchAll();
    }
    
    // Comprueba que la plataforma introducida existe
    function checkPlatformExists($platforms): bool {
        foreach ($platforms as $platform) {
            $query = $this->pdo->prepare(self::BASE . "WHERE platformID = ?");
            $query->execute([$platform]);
            
            if(count($query->fetchAll())==0){
                return false;
            }
        }

        return true;
    }

}
