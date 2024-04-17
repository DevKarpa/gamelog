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
    
    function checkUserExists($username) {
        $query = $this->pdo->prepare(self::BASE . "WHERE username = ?");
        $query->execute([$username]);
        $user = $query->fetch();
        
        if($user){
            return true;
        }
        
        return false;
    }
    
    function registerUser($user): array {
        $query = $this->pdo->prepare("INSERT INTO users (username, password, userType) VALUES (?, ?, ?)");
        $query->execute([$user['username'], password_hash($user['pass'], PASSWORD_DEFAULT), 0]);
        
        return $this->loginUser($user['username'], $user['pass']);
    }
    
    function getUserById($id) {
        $query = $this->pdo->prepare(self::BASE . "WHERE userID = ?");
        $query->execute([$id]);
        $user = $query->fetch();
        
        return $user;
    }
    
    function deleteUserById($id) {
        $query = $this->pdo->prepare("DELETE FROM users WHERE userID = ?");
        $query->execute([$id]);
        
        $queryu = $this->pdo->prepare("DELETE FROM userGames WHERE userID = ?");
        $queryu->execute([$id]);
    }
    
    function editUserData($userdata,$id) {
        $query = $this->pdo->prepare("UPDATE users SET username = ?, password= ?, userType = ? WHERE userID = ?");
        $query->execute([$userdata['username'],$userdata['pass'],$userdata['userType'],$id]);
    }
    
    function checkUsernameExists($id,$username) {
        $query = $this->pdo->prepare(self::BASE . "WHERE username = ?");
        $query->execute([$username]);
        $user = $query->fetch();
        
        if($user){
            if($user['userID']==$id){
                return false;
            }else{
                return true;
            }
        }
        
        return false;
    }
    
    function changeUsername($id,$username) {
        $query = $this->pdo->prepare("UPDATE users SET username = ? WHERE userID = ?");
        $query->execute([$username,$id]);
    }
    
    function changePassword($id,$pass) {
        $query = $this->pdo->prepare("UPDATE users SET password = ? WHERE userID = ?");
        $query->execute([password_hash($pass, PASSWORD_DEFAULT),$id]);
    }
    
    function getFriendsFromUserID($id) {
        $query = $this->pdo->prepare(self::BASE . "JOIN userFriends ON users.userID = userFriends.friendUserID WHERE userFriends.mainUserID = ?");
        $query->execute([$id]);
        return $query->fetchAll();
    }
    
    function getFriendsIDFromUserID($id) {
        $query = $this->pdo->prepare("SELECT userID FROM users JOIN userFriends ON users.userID = userFriends.friendUserID WHERE userFriends.mainUserID = ?");
        $query->execute([$id]);
        $friends = [];
        
        foreach ($query->fetchAll() as $friendID) {
            $friends[] = $friendID['userID'];
        }
        
        return $friends;
    }
    
    function addNewFriend($mainUserID,$friendUserID) {
        $query = $this->pdo->prepare("INSERT INTO userFriends(mainUserID, friendUserId) VALUES (?,?)");
        $query->execute([$mainUserID,$friendUserID]);
        $query->execute([$friendUserID,$mainUserID]);
    }

}
