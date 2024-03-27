<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

class UserModel extends \Com\Daw2\Core\BaseModel {

    private const BASE = "SELECT * FROM users ";

    function getAllUsers(): array {
        $stmt = $this->pdo->query(self::BASE);
        return $stmt->fetchAll();
    }
    
    function loginUser($username, $pass): ?array {

        $query = $this->pdo->prepare(self::BASE . 'WHERE username = ?');
        $query->execute([$username]);
        $user = $query->fetch();

        if ($user) {
            var_dump(password_verify($pass, $user['password']));
            if (password_verify($pass, $user['password'])) {
                
                return $user;
            }
        }
        
        return null;
    }

}
