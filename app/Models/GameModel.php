<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

class GameModel extends \Com\Daw2\Core\BaseModel {

    private const BASE = "SELECT games.gameID, games.gameTitle, games.gameYear, games.gameScore, GROUP_CONCAT(devs.devName ORDER BY devs.devName ASC) AS developers FROM games JOIN devGames ON games.gameID = devGames.gameID JOIN devs ON devGames.devID = devs.devID GROUP BY games.gameID;";

    function getAll(): array {
        $stmt = $this->pdo->query(self::BASE);
        return $stmt->fetchAll();
    }
    
    function addNewGame($metadata) {
        
    }
}
