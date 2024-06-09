<?php

use PHPUnit\Framework\TestCase;

class UserControllerTest extends TestCase {
    
    public function testCheckUserPassword() {
        
        $controller = new Com\Gamelog\Controllers\UserController();

        $this->assertIsNotArray($controller->checkUserPassword('1qazXSW"', '1qazXSW"'));
        
    }
}