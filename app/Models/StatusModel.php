<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

class StatusModel extends \Com\Daw2\Core\BaseModel {
    
    function getAllStatus(): array {
        $query = $this->pdo->query("SELECT * FROM status ");
        $query->execute();

        return $query->fetchAll();
    }
    
    function checkStatusExistsById($id): bool {
        $statusList = $this->getAllStatus();
        
        foreach ($statusList as $status) {
            if($status['statusID']==$id){
                return true;
            }
        }
        
        return false;
    }
}
