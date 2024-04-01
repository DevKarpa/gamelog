<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

class UserGamesModel extends \Com\Daw2\Core\BaseModel {
    
    const BASE = "SELECT games.gameID, games.gameTitle, GROUP_CONCAT(devs.devName ORDER BY devs.devName ASC) AS developers, platforms.platformName, userGames.fechaInicio, userGames.fechaFin, status.statusName FROM games JOIN devGames ON games.gameID = devGames.gameID JOIN devs ON devGames.devID = devs.devID JOIN userGames ON games.gameID = userGames.gameID JOIN status ON userGames.statusID = status.statusID JOIN platforms ON games.gamePlatform = platforms.platformID ";

    function getGamesByUserID($id) {
        $query = $this->pdo->prepare(self::BASE . "WHERE userGames.userID = ? GROUP BY games.gameID");
        $query->execute([$id]);

        return $query->fetchAll();
    }
}
