<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

class GameModel extends \Com\Daw2\Core\BaseModel {

    private const BASE = "SELECT *, GROUP_CONCAT(devs.devName ORDER BY devs.devName ASC) AS developers FROM games JOIN devGames ON games.gameID = devGames.gameID JOIN devs ON devGames.devID = devs.devID JOIN platforms on games.gamePlatform = platforms.platformID  ";

    // Obtiene todos los juegos
    function getAll(): array {
        $query = $this->pdo->query(self::BASE . "GROUP BY games.gameID");
        $query->execute();

        return $query->fetchAll();
    }

    // Guarda el juego en la base de datos, y en otra para relacionarlo con los devs
    // ademas de guardar la imagen del juego localmente.
    function saveNewGame($metadata, $img) {
        
        $count = 1;

        // Guarda el juego en la tabla games
        foreach ($metadata['platform'] as $platform) {
            $query = $this->pdo->prepare("INSERT INTO games (gameTitle,gameYear,gamePlatform) VALUES (?,?,?)");
            $query->execute([$metadata['name'], $metadata['year'], $platform]);
            
            // Relaciona el juego con la/las desarrolladoras añadiendo los registros necesarios en la tabla
            // devGames
            foreach ($metadata['devs'] as $dev) {
                $query = $this->pdo->prepare("INSERT INTO devGames (devID,gameID) VALUES (?,?)");
                $query->execute([$dev, $this->getLastRegister()]);
            }


            // Llamada a la función que guarda la imagen
            if(count($metadata['platform'])==$count){
                $this->saveImage($img, 0);
            }else{
                $this->copyImage($img, 0);
            }
            
            
            $count++;
        }

    }

    // Le da un nombre a la imagen tomando como base el ID del último juego 
    // introducido, y se asigna una ruta a ella.
    function saveImage($img, $id) {
        if ($id == 0) {
            $id = $this->getLastRegister();
        }
        $dir = "assets/img/games/" . $id . ".png";
        move_uploaded_file($img["image"]["tmp_name"], $dir);
    }
    
    function copyImage($img, $id) {
        if ($id == 0) {
            $id = $this->getLastRegister();
        }
        $dir = "assets/img/games/" . $id . ".png";
        copy($img["image"]["tmp_name"], $dir);
    }

    // Devuelve el último gameID de la tabla games
    function getLastRegister(): int {
        $query = $this->pdo->query("SELECT gameID FROM games ORDER BY gameID DESC");
        $query->execute();
        return $query->fetch()['gameID'];
    }

    // Devuelve un juego desde la ID pasada por parámetro
    function getGameById($id) {
        $query = $this->pdo->prepare(self::BASE . "WHERE games.gameID = ? GROUP BY games.gameID");
        $query->execute([$id]);
        return $query->fetch();
    }

    // Elimina un juego y sus registros en otras tablas
    function deleteGameById($id) {
        $queryd = $this->pdo->prepare("DELETE FROM devGames WHERE gameID = ?");
        $queryd->execute([$id]);

        $queryg = $this->pdo->prepare("DELETE FROM games WHERE gameID = ?");
        $queryg->execute([$id]);

        $queryu = $this->pdo->prepare("DELETE FROM userGames WHERE gameID = ?");
        $queryu->execute([$id]);
    }

    // Elimina registro de la tabla devGames
    function deleteDevGamesById($id) {
        $queryd = $this->pdo->prepare("DELETE FROM devGames WHERE gameID = ?");
        $queryd->execute([$id]);
    }

    // Modifica los datos de un juego 
    function modifyGameData($metadata, $img, $id) {
        // Actualiza la tabla games con los nuevos datos del juego
        $query = $this->pdo->prepare("UPDATE games SET gameTitle = ?, gameYear = ?, gamePlatform = ? WHERE gameID = ?");
        $query->execute([$metadata['name'], $metadata['year'], $metadata['platform'], $id]);

        $this->deleteDevGamesById($id);

        // Relaciona el juego con la/las desarrolladoras añadiendo los registros necesarios en la tabla
        // devGames
        foreach ($metadata['devs'] as $dev) {
            $query = $this->pdo->prepare("INSERT INTO devGames (devID,gameID) VALUES (?,?)");
            $query->execute([$dev, $id]);
        }

        // Llamada a la función que guarda la imagen
        $this->saveImage($img, $id);
    }

    // Búsqueda por filtro y paginación
    function filterSearchGames($filter, $offset) {
        $values = [];
        $where = [];

        if (strlen($filter['name']) != 0) {
            $where[] = " games.gameTitle LIKE ? ";
            $values[] = "%" . $filter['name'] . "%"; //contiene
        }

        if (strlen($filter['year']) != 0) {
            $where[] = " games.gameYear = ? ";
            $values[] = (int) $filter['year'];
        }

        if (isset($filter['devID'])) {
            foreach ($filter['devID'] as $devID) {
                $where[] = " devGames.devID = ? ";
                $values[] = (int) $devID;
            }
        }

        if (strlen($filter['plataforma']) != 0) {
            $where[] = " games.gamePlatform = ? ";
            $values[] = (int) $filter['plataforma'];
        }

        if (is_null($offset)) {
            $query = $this->pdo->prepare(self::BASE . "WHERE  " . implode("AND", $where) . " GROUP BY games.gameID");
        } else {
            $query = $this->pdo->prepare(self::BASE . "WHERE  " . implode("AND", $where) . " GROUP BY games.gameID LIMIT 5 OFFSET ?");
            $values[] = $offset;
        }

        $query->execute($values);

        return $query->fetchAll();
    }

    function getPageGames($offset) {
        $query = $this->pdo->prepare(self::BASE . "GROUP BY games.gameID LIMIT 5 OFFSET ?");
        $query->execute([$offset]);
        return $query->fetchAll();
    }
    
    

    
}
