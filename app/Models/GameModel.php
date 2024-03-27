<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

class GameModel extends \Com\Daw2\Core\BaseModel {

    private const BASE = "SELECT games.gameID, games.gameTitle, games.gameYear, platforms.platformName, GROUP_CONCAT(devs.devName ORDER BY devs.devName ASC) AS developers FROM games JOIN devGames ON games.gameID = devGames.gameID JOIN devs ON devGames.devID = devs.devID JOIN platforms on games.gamePlatform = platforms.platformID GROUP BY games.gameID ";

    function getAll(): array {
        $query = $this->pdo->query(self::BASE);
        $query->execute();
        
        return $query->fetchAll();
    }

    function saveNewGame($metadata, $img) {
        
        var_dump($metadata);
        
        // Guarda el juego en la tabla games
        $query = $this->pdo->prepare("INSERT INTO games (gameTitle,gameYear,gamePlatform) VALUES (?,?,?)");
        $query->execute([$metadata['name'],$metadata['year'],$metadata['platform']]);
        
        // Relaciona el juego con la/las desarrolladoras añadiendo los registros necesarios en la tabla
        // devGames
        foreach ($metadata['devs'] as $dev) {
            $query = $this->pdo->prepare("INSERT INTO devGames (devID,gameID) VALUES (?,?)");
            $query->execute([$dev,$this->getLastRegister()]);
        }
        
        // Llamada a la función que guarda la imagen
        $this->saveImage($img);
    }
    
    function saveImage($img) {
        $dir = "assets/img/games/" . $this->getLastRegister() . ".png";
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
}
