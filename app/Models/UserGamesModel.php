<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

class UserGamesModel extends \Com\Daw2\Core\BaseModel {

    const BASE = "SELECT games.gameID, games.gameTitle, GROUP_CONCAT(devs.devName ORDER BY devs.devName ASC) AS developers, platforms.platformName, userGames.fechaInicio, userGames.fechaFin, status.statusID, status.statusName, userGames.nota FROM games JOIN devGames ON games.gameID = devGames.gameID JOIN devs ON devGames.devID = devs.devID JOIN userGames ON games.gameID = userGames.gameID JOIN status ON userGames.statusID = status.statusID JOIN platforms ON games.gamePlatform = platforms.platformID ";

    // Obtiene todos los juegos de un usuario
    function getGamesByUserID($id) {
        $query = $this->pdo->prepare(self::BASE . "WHERE userGames.userID = ? GROUP BY games.gameID");
        $query->execute([$id]);

        return $query->fetchAll();
    }

    // Obtiene todos los ID de juegos de un usuario
    function getGamesIDByUserID($id) {
        $gameidlist = [];
        $query = $this->pdo->prepare(self::BASE . "WHERE userGames.userID = ? GROUP BY games.gameID");
        $query->execute([$id]);

        foreach ($query->fetchAll() as $game) {
            $gameidlist[] = $game['gameID'];
        }

        return $gameidlist;
    }

    // Añade un nuevo registro a userGames con posibilidad de nulos
    function addNewRegister($id, $reg, $user):void {

        // Si la fecha está vacía, guarda null
        if (!strtotime($reg['fecha'][1])) {
            $reg['fecha'][1] = null;
        }

        if (!strtotime($reg['fecha'][0])) {
            $reg['fecha'][0] = null;
        }

        if (empty($reg['note'])) {
            $reg['note'] = null;
        }
        var_dump($reg['fecha']);
        $query = $this->pdo->prepare("INSERT INTO userGames (userID, gameID, fechaInicio, fechaFin, nota, statusID) VALUES (?,?,?,?,?,?)");
        $query->execute([$user['userID'], $id, $reg['fecha'][0], $reg['fecha'][1], $reg['note'], $reg['status']]);
    }

    // Comprueba si un usuario tiene cierto juego
    function checkUserHasGame($id, $user):bool {
        $query = $this->pdo->prepare(self::BASE . "WHERE userGames.userID = ? AND userGames.gameID = ? GROUP BY games.gameID");
        $query->execute([$user['userID'], $id]);
        $hasGame = $query->fetch();

        if ($hasGame) {
            return true;
        }

        return false;
    }

    // Elimina un juego del registro
    function deleteGameRegister($id, $user) {
        $query = $this->pdo->prepare("DELETE FROM userGames WHERE userID = ? AND gameID = ?");
        $query->execute([$user['userID'], $id]);
    }

    // Obtiene el id del registro
    function getRegisterByID($id, $user) {
        $query = $this->pdo->prepare("SELECT * FROM userGames WHERE userGames.userID = ? AND gameID = ?");
        $query->execute([$user['userID'], $id]);

        return $query->fetch();
    }

    // Obtiene los juegos por paginación
    function getPagedGamesByUserID($offset, $id) {
        $query = $this->pdo->prepare(self::BASE . "WHERE userGames.userID = ? GROUP BY games.gameID LIMIT 10 OFFSET ?");
        $query->execute([$id, $offset]);
        return $query->fetchAll();
    }
    
    // Obtiene los juegos por ID de usuario y status
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

    // Obtiene los juegos por ID de usuario y status con paginación ordenado por Nombre
    function getPagedGamesByUserIDandName($id, $offset, $status) {
        if ($status >= 0 && $status <= 3) {
            $query = $this->pdo->prepare(self::BASE . "WHERE userGames.userID = ? AND status.statusID = ? GROUP BY games.gameID ORDER BY games.gameTitle LIMIT 10 OFFSET ? ");
            $query->execute([$id, $status, $offset]);
        } else {
            $query = $this->pdo->prepare(self::BASE . "WHERE userGames.userID = ? GROUP BY games.gameID ORDER BY games.gameTitle LIMIT 10 OFFSET ? ");
            $query->execute([$id, $offset]);
        }
        return $query->fetchAll();
    }

    // Obtiene los juegos por ID de usuario y status con paginación ordenado por Devs
    function getPagedGamesByUserIDandDevs($id, $offset, $status) {
        if ($status >= 0 && $status <= 3) {
            $query = $this->pdo->prepare(self::BASE . "WHERE userGames.userID = ? AND status.statusID = ? GROUP BY games.gameID ORDER BY developers LIMIT 10 OFFSET ?");
            $query->execute([$id, $status, $offset]);
        }else{
            $query = $this->pdo->prepare(self::BASE . "WHERE userGames.userID = ? GROUP BY games.gameID ORDER BY developers LIMIT 10 OFFSET ?");
            $query->execute([$id, $offset]);
        }

        return $query->fetchAll();
    }

    // Obtiene los juegos por ID de usuario y status con paginación ordenado por Fecha de inicio
    function getPagedGamesByUserIDandInicio($id, $offset, $status) {
        if ($status >= 0 && $status <= 3) {
            $query = $this->pdo->prepare(self::BASE . "WHERE userGames.userID = ? AND status.statusID = ? GROUP BY games.gameID ORDER BY userGames.fechaInicio LIMIT 10 OFFSET ?");
            $query->execute([$id, $status, $offset]);
        }else{
            $query = $this->pdo->prepare(self::BASE . "WHERE userGames.userID = ? GROUP BY games.gameID ORDER BY userGames.fechaInicio LIMIT 10 OFFSET ?");
            $query->execute([$id, $offset]);
        }

        return $query->fetchAll();
    }

    // Obtiene los juegos por ID de usuario y status con paginación ordenado por Fin
    function getPagedGamesByUserIDandFin($id, $offset, $status) {
        if ($status >= 0 && $status <= 3) {
            $query = $this->pdo->prepare(self::BASE . "WHERE userGames.userID = ? AND status.statusID = ? GROUP BY games.gameID ORDER BY userGames.fechaFin LIMIT 10 OFFSET ?");
            $query->execute([$id, $status, $offset]);
        }else{
            $query = $this->pdo->prepare(self::BASE . "WHERE userGames.userID = ? GROUP BY games.gameID ORDER BY userGames.fechaFin LIMIT 10 OFFSET ?");
            $query->execute([$id, $offset]);
        }

        return $query->fetchAll();
    }
    
    function getCompletedGamesByUserID($id) {
        $query = $this->pdo->prepare(self::BASE . "WHERE userGames.userID = ? AND status.statusID = 3 GROUP BY games.gameID");
        $query->execute([$id]);

        return $query->fetchAll();
    }
    
    function getPlayingGamesByUserID($id) {
        $query = $this->pdo->prepare(self::BASE . "WHERE userGames.userID = ? AND status.statusID = 2 GROUP BY games.gameID");
        $query->execute([$id]);

        return $query->fetchAll();
    }
    
    function getPendingGamesByUserID($id) {
        $query = $this->pdo->prepare(self::BASE . "WHERE userGames.userID = ? AND status.statusID = 1 GROUP BY games.gameID");
        $query->execute([$id]);

        return $query->fetchAll();
    }
    
    function getDroppedGamesByUserID($id) {
        $query = $this->pdo->prepare(self::BASE . "WHERE userGames.userID = ? AND status.statusID = 0 GROUP BY games.gameID");
        $query->execute([$id]);

        return $query->fetchAll();
    }
}
