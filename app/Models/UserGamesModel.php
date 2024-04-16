<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

class UserGamesModel extends \Com\Daw2\Core\BaseModel {

    const BASE = "SELECT games.gameID, games.gameTitle, GROUP_CONCAT(devs.devName ORDER BY devs.devName ASC) AS developers, platforms.platformName, userGames.fechaInicio, userGames.fechaFin, status.statusID, status.statusName FROM games JOIN devGames ON games.gameID = devGames.gameID JOIN devs ON devGames.devID = devs.devID JOIN userGames ON games.gameID = userGames.gameID JOIN status ON userGames.statusID = status.statusID JOIN platforms ON games.gamePlatform = platforms.platformID ";

    function getGamesByUserID($id) {
        $query = $this->pdo->prepare(self::BASE . "WHERE userGames.userID = ? GROUP BY games.gameID");
        $query->execute([$id]);

        return $query->fetchAll();
    }

    function getGamesIDByUserID($id) {
        $gameidlist = [];
        $query = $this->pdo->prepare(self::BASE . "WHERE userGames.userID = ? GROUP BY games.gameID");
        $query->execute([$id]);

        foreach ($query->fetchAll() as $game) {
            $gameidlist[] = $game['gameID'];
        }

        return $gameidlist;
    }

    function addNewRegister($id, $reg, $user) {

        // Si la fecha está vacía, guarda null
        if (!strtotime($reg['end'])) {
            $reg['end'] = null;
        }

        if (!strtotime($reg['start'])) {
            $reg['start'] = null;
        }

        if (empty($reg['note'])) {
            $reg['note'] = null;
        }

        $query = $this->pdo->prepare("INSERT INTO userGames (userID, gameID, fechaInicio, fechaFin, nota, statusID) VALUES (?,?,?,?,?,?)");
        $query->execute([$user['userID'], $id, $reg['start'], $reg['end'], $reg['note'], $reg['status']]);
    }

    function checkUserHasGame($id, $user) {
        $query = $this->pdo->prepare(self::BASE . "WHERE userGames.userID = ? AND userGames.gameID = ? GROUP BY games.gameID");
        $query->execute([$user['userID'], $id]);
        $hasGame = $query->fetch();

        if ($hasGame) {
            return true;
        }

        return false;
    }

    function deleteGameRegister($id, $user) {
        $query = $this->pdo->prepare("DELETE FROM userGames WHERE userID = ? AND gameID = ?");
        $query->execute([$user['userID'], $id]);
    }

    function getRegisterByID($id, $user) {
        $query = $this->pdo->prepare("SELECT * FROM userGames WHERE userGames.userID = ? AND gameID = ?");
        $query->execute([$user['userID'], $id]);

        return $query->fetch();
    }

    function getPagedGamesByUserID($offset, $id) {
        $query = $this->pdo->prepare(self::BASE . "WHERE userGames.userID = ? GROUP BY games.gameID LIMIT 5 OFFSET ?");
        $query->execute([$id, $offset]);
        return $query->fetchAll();
    }
    
    function getGamesByUserIDandStatus($id,$status) {
        if ($status >= 0 && $status <= 3) {
            $query = $this->pdo->prepare(self::BASE . "WHERE userGames.userID = ? AND status.statusID = ? GROUP BY games.gameID ");
            $query->execute([$id, $status]);
        } else {
            $query = $this->pdo->prepare(self::BASE . "WHERE userGames.userID = ? GROUP BY games.gameID ");
            $query->execute([$id]);
        }
        return $query->fetchAll();
    }

    function getPagedGamesByUserIDandName($id, $offset, $status) {
        if ($status >= 0 && $status <= 3) {
            $query = $this->pdo->prepare(self::BASE . "WHERE userGames.userID = ? AND status.statusID = ? GROUP BY games.gameID ORDER BY games.gameTitle LIMIT 5 OFFSET ? ");
            $query->execute([$id, $status, $offset]);
        } else {
            $query = $this->pdo->prepare(self::BASE . "WHERE userGames.userID = ? GROUP BY games.gameID ORDER BY games.gameTitle LIMIT 5 OFFSET ? ");
            $query->execute([$id, $offset]);
        }
        return $query->fetchAll();
    }

    function getPagedGamesByUserIDandDevs($id, $offset, $status) {
        if ($status >= 0 && $status <= 3) {
            $query = $this->pdo->prepare(self::BASE . "WHERE userGames.userID = ? AND status.statusID = ? GROUP BY games.gameID ORDER BY developers LIMIT 5 OFFSET ?");
            $query->execute([$id, $status, $offset]);
        }else{
            $query = $this->pdo->prepare(self::BASE . "WHERE userGames.userID = ? GROUP BY games.gameID ORDER BY developers LIMIT 5 OFFSET ?");
            $query->execute([$id, $offset]);
        }

        return $query->fetchAll();
    }

    function getPagedGamesByUserIDandInicio($id, $offset, $status) {
        if ($status >= 0 && $status <= 3) {
            $query = $this->pdo->prepare(self::BASE . "WHERE userGames.userID = ? AND status.statusID = ? GROUP BY games.gameID ORDER BY userGames.fechaInicio LIMIT 5 OFFSET ?");
            $query->execute([$id, $status, $offset]);
        }else{
            $query = $this->pdo->prepare(self::BASE . "WHERE userGames.userID = ? GROUP BY games.gameID ORDER BY userGames.fechaInicio LIMIT 5 OFFSET ?");
            $query->execute([$id, $offset]);
        }

        return $query->fetchAll();
    }

    function getPagedGamesByUserIDandFin($id, $offset, $status) {
        if ($status >= 0 && $status <= 3) {
            $query = $this->pdo->prepare(self::BASE . "WHERE userGames.userID = ? AND status.statusID = ? GROUP BY games.gameID ORDER BY userGames.fechaFin LIMIT 5 OFFSET ?");
            $query->execute([$id, $status, $offset]);
        }else{
            $query = $this->pdo->prepare(self::BASE . "WHERE userGames.userID = ? GROUP BY games.gameID ORDER BY userGames.fechaFin LIMIT 5 OFFSET ?");
            $query->execute([$id, $offset]);
        }

        return $query->fetchAll();
    }
}
