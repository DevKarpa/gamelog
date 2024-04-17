<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

class DevModel extends \Com\Daw2\Core\BaseModel {

    private const BASE = "SELECT * FROM devs ";

    // Obtiene todos los devs ordenados por nombre
    function getAllDevs(): array {
        $stmt = $this->pdo->query(self::BASE . " ORDER BY devName ASC");
        return $stmt->fetchAll();
    }

    // Obtiene todos los devs ordenados por ID
    function getAllDevsIDordered(): array {
        $stmt = $this->pdo->query(self::BASE . " ORDER BY devID ASC");
        return $stmt->fetchAll();
    }

    // Comprueba si los devs pasados por parámetro ya existen, por ID
    function checkDevExists($inputDevs) {
        $devs = $this->getAllDevs();

        foreach ($devs as $dev) {
            foreach ($inputDevs as $inputDev) {
                if ($inputDev == $dev['devID']) {
                    return true;
                }
            }
        }

        return false;
    }
    
    // Obtiene un dev desde una ID
    function getDevById($id) {
        $stmt = $this->pdo->prepare(self::BASE . " WHERE devID = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // Comprueba si los devs pasados por parámetro ya existen, por nombre
    function checkDevExistsByName($inputDevs) {
        $devs = $this->getAllDevs();
        $errores = [];

        foreach ($devs as $dev) {
            foreach ($inputDevs as $inputDev) {
                if (strtolower($inputDev) == strtolower($dev['devName'])) {
                    $errores[] = $dev['devName'] . " ya existe";
                }
            }
        }

        return $errores;
    }

    // Obtiene los devID del juego con el id pasado por pa´rametro.
    function getDevGamesById($id) {
        $query = $this->pdo->prepare("SELECT devID FROM devGames WHERE gameID = ?");
        $query->execute([$id]);
        return $query->fetchAll();
    }
    
    // Añade los devs pasados por parámetro a la base de datos
    function addNewDevs($devs) {
        foreach ($devs as $dev) {
            $query = $this->pdo->prepare("INSERT INTO devs (devName) VALUES (?)");
            $query->execute([$dev]); 
        }
    }
    
    // Elimina un dev por ID
    function deleteDevById($id) {
        $query = $this->pdo->prepare("DELETE FROM devs WHERE devID = ?");
        $query->execute([$id]);
        return $query->fetchAll();
    }
    
    // Marca como dev el valor = 1, que se usa por defecto cuando borras un
    // dev que ya tenía juegos asociados para evitar datos nulos.
    function deleteDevFromGame($id) {
        $queryd = $this->pdo->prepare("UPDATE devGames SET devID = 1 WHERE devID = ?");
        $queryd->execute([$id]);
    }
}
