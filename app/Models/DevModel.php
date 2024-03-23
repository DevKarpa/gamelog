<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

class DevModel extends \Com\Daw2\Core\BaseModel {

    private const BASE = "SELECT * FROM devs ";

    function getAllDevs(): array {
        $stmt = $this->pdo->query(self::BASE . " ORDER BY devName ASC");
        return $stmt->fetchAll();
    }

}
