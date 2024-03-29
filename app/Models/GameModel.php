<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

class GameModel extends \Com\Daw2\Core\BaseModel {

    private const BASE = "SELECT *, GROUP_CONCAT(devs.devName ORDER BY devs.devName ASC) AS developers FROM games JOIN devGames ON games.gameID = devGames.gameID JOIN devs ON devGames.devID = devs.devID JOIN platforms on games.gamePlatform = platforms.platformID  ";

    function getAll(): array {
        $query = $this->pdo->query(self::BASE . "GROUP BY games.gameID");
        $query->execute();

        return $query->fetchAll();
    }

    function saveNewGame($metadata, $img) {

        // Guarda el juego en la tabla games
        $query = $this->pdo->prepare("INSERT INTO games (gameTitle,gameYear,gamePlatform) VALUES (?,?,?)");
        $query->execute([$metadata['name'], $metadata['year'], $metadata['platform']]);

        // Relaciona el juego con la/las desarrolladoras añadiendo los registros necesarios en la tabla
        // devGames
        foreach ($metadata['devs'] as $dev) {
            $query = $this->pdo->prepare("INSERT INTO devGames (devID,gameID) VALUES (?,?)");
            $query->execute([$dev, $this->getLastRegister()]);
        }

        // Llamada a la función que guarda la imagen
        $this->saveImage($img,0);
    }

    function saveImage($img,$id) {
        if($id==0){
            $id = $this->getLastRegister();
        }
        $dir = "assets/img/games/" . $id . ".png";
        move_uploaded_file($img["image"]["tmp_name"], $dir);
    }

    /**
     * Devuelve el último gameID de la tabla games
     * @return int
     */
    function getLastRegister(): int {
        $query = $this->pdo->query("SELECT gameID FROM games ORDER BY gameID DESC");
        $query->execute();
        return $query->fetch()['gameID'];
    }

    function getGameById($id) {
        $query = $this->pdo->prepare(self::BASE . "WHERE games.gameID = ? GROUP BY games.gameID");
        $query->execute([$id]);
        return $query->fetch();
    }

    function deleteGameById($id) {
        $queryd = $this->pdo->prepare("DELETE FROM devGames WHERE gameID = ?");
        $queryd->execute([$id]);

        $queryg = $this->pdo->prepare("DELETE FROM games WHERE gameID = ?");
        $queryg->execute([$id]);
        
        $queryu = $this->pdo->prepare("DELETE FROM userGames WHERE gameID = ?");
        $queryu->execute([$id]);
    }
    
    function deleteDevGamesById($id) {
        $queryd = $this->pdo->prepare("DELETE FROM devGames WHERE gameID = ?");
        $queryd->execute([$id]);
    }

    function modifyGameData($metadata, $img, $id) {
        // Actualiza la tabla games con los nuevos datos del juego
        $query = $this->pdo->prepare("UPDATE games SET gameTitle = ?, gameYear = ?, gamePlatform = ? WHERE gameID = ?");
        $query->execute([$metadata['name'],$metadata['year'],$metadata['platform'],$id]);
        
        $this->deleteDevGamesById($id);
        
        // Relaciona el juego con la/las desarrolladoras añadiendo los registros necesarios en la tabla
        // devGames
        foreach ($metadata['devs'] as $dev) {
            $query = $this->pdo->prepare("INSERT INTO devGames (devID,gameID) VALUES (?,?)");
            $query->execute([$dev, $id]);
        }

        // Llamada a la función que guarda la imagen
        $this->saveImage($img,$id);
    }
}
