<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

class UserModel extends \Com\Daw2\Core\BaseModel {

    private const BASE = "SELECT * FROM users ";

    // Obtiene todos los usuarios
    function getAllUsers(): array {
        $stmt = $this->pdo->query(self::BASE);
        return $stmt->fetchAll();
    }

    // Hace login al usuario comprobando la contraseña
    function loginUser($username, $pass): ?array {
        $query = $this->pdo->prepare(self::BASE . 'WHERE username = ?');
        $query->execute([$username]);
        $user = $query->fetch();

        if ($user) {
            if (password_verify($pass, $user['password'])) {
                return $user;
            }
        }
        return null;
    }

    // Comprueba si un nombre de usuario ya existe
    function checkUserExists($username): bool {
        $query = $this->pdo->prepare(self::BASE . "WHERE username = ?");
        $query->execute([$username]);
        $user = $query->fetch();

        if ($user) {
            return true;
        }

        return false;
    }

    // Registra al usuario añadiendo un registro a la tabla users
    function registerUser($user): array {
        $query = $this->pdo->prepare("INSERT INTO users (username, password, userType) VALUES (?, ?, ?)");
        $query->execute([$user['username'], password_hash($user['pass'], PASSWORD_DEFAULT), 0]);

        return $this->loginUser($user['username'], $user['pass']);
    }

    // Obtiene un usuario a partir de su id
    function getUserById($id): array {
        $query = $this->pdo->prepare(self::BASE . "WHERE userID = ?");
        $query->execute([$id]);
        $user = $query->fetch();

        return $user;
    }

    // Elimina un usuario a partir de su id, además de sus otros registros
    function deleteUserById($id): void {
        $query = $this->pdo->prepare("DELETE FROM users WHERE userID = ?");
        $query->execute([$id]);

        $queryu = $this->pdo->prepare("DELETE FROM userGames WHERE userID = ?");
        $queryu->execute([$id]);
    }

    // Edita los datos de un usuario
    function editUserData($userdata, $id): void {
        $query = $this->pdo->prepare("UPDATE users SET username = ?, password= ?, userType = ? WHERE userID = ?");
        $query->execute([$userdata['username'], $userdata['pass'], $userdata['userType'], $id]);
    }

    // Comprueba si el nombre de usuario ya existe, dejándolo pasar si este
    // se trata del mismo usuario logeado
    function checkUsernameExists($id, $username): bool {
        $query = $this->pdo->prepare(self::BASE . "WHERE username = ?");
        $query->execute([$username]);
        $user = $query->fetch();

        if ($user) {
            if ($user['userID'] == $id) {
                return false;
            } else {
                return true;
            }
        }

        return false;
    }

    // Cambia el username de un usuario
    function changeUsername($id, $username): void {
        $query = $this->pdo->prepare("UPDATE users SET username = ? WHERE userID = ?");
        $query->execute([$username, $id]);
    }

    // Cambia la contraseña de un usuario
    function changePassword($id, $pass): void {
        $query = $this->pdo->prepare("UPDATE users SET password = ? WHERE userID = ?");
        $query->execute([password_hash($pass, PASSWORD_DEFAULT), $id]);
    }
    
    function changeDisplayName($id, $displayname) {
        $query = $this->pdo->prepare("UPDATE users SET userDisplayName = ? WHERE userID = ?");
        $query->execute([$displayname, $id]);
    }
    
    function updateDescription($id, $desc) {
        $query = $this->pdo->prepare("UPDATE users SET userDesc = ? WHERE userID = ?");
        $query->execute([$desc, $id]);
    }

    // Obtiene los amigos de un usuario
    function getFriendsFromUserID($id): ?array {
        $query = $this->pdo->prepare(self::BASE . "JOIN userFriends ON users.userID = userFriends.friendUserID WHERE userFriends.mainUserID = ?");
        $query->execute([$id]);
        return $query->fetchAll();
    }

    // Obtiene los ID de amigos de un usuario
    function getFriendsIDFromUserID($id): ?array {
        $query = $this->pdo->prepare("SELECT userID FROM users JOIN userFriends ON users.userID = userFriends.friendUserID WHERE userFriends.mainUserID = ?");
        $query->execute([$id]);
        $friends = [];

        foreach ($query->fetchAll() as $friendID) {
            $friends[] = $friendID['userID'];
        }

        return $friends;
    }

    // Añade un amigo a la lista
    function addNewFriend($mainUserID, $friendUserID): void {
        $query = $this->pdo->prepare("INSERT INTO userFriends(mainUserID, friendUserId) VALUES (?,?)");
        $query->execute([$mainUserID, $friendUserID]);
        // Por el momento los añade mutuamente
        $query->execute([$friendUserID,$mainUserID]);
    }
    
}
