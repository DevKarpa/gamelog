<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

class UserModel extends \Com\Daw2\Core\BaseModel {

    private const BASE = "SELECT games.gameID, games.gameTitle, games.gameYear, platforms.platformName, GROUP_CONCAT(devs.devName ORDER BY devs.devName ASC) AS developers FROM games JOIN devGames ON games.gameID = devGames.gameID JOIN devs ON devGames.devID = devs.devID JOIN platforms on games.gamePlatform = platforms.platformID GROUP BY games.gameID ";

    function getAllUsers(): array {
        $stmt = $this->pdo->query(self::BASE);
        return $stmt->fetchAll();
    }

}
