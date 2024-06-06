<?php

use PHPUnit\Framework\TestCase;
require_once '../app/Controllers/UserController.php';

class UserControllerTest extends TestCase {
    
    public function testCheckUserPassword() {
        
        $controller = new Com\Gamelog\Controllers\UserController();

        $this->assertIsNotArray($controller->
                checkUserPassword('1234', '1234'));
        
    }
}