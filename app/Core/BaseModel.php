<?php
declare(strict_types=1);

namespace Com\Gamelog\Core;

use \PDO; 

abstract class BaseModel {
    protected $pdo;

    function __construct() {
        $this->pdo = DBManager::getInstance()->getConnection();      
    }
}
