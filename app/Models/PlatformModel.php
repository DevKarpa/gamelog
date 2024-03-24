<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

class PlatformModel extends \Com\Daw2\Core\BaseModel {

    private const BASE = "SELECT * FROM platforms ORDER BY platformName ASC ";

    function getAllPlatforms(): array {
        $stmt = $this->pdo->query(self::BASE);
        return $stmt->fetchAll();
    }

}
