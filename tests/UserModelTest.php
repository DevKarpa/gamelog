<?php
use PHPUnit\Framework\TestCase;

class UserModelTest extends TestCase {
    
    
    public function testLoginUser() {
        $dotenv = Dotenv\Dotenv::createImmutable('../');
        $dotenv->load();
        
        $model = new Com\Gamelog\Models\UserModel();
        
        $username = "alex";
        $password = '1qazXSW"';

        $this->assertIsArray($model->loginUser($username, $password));
        
    }
    
    public function testCheckUserExists() {
        $dotenv = Dotenv\Dotenv::createImmutable('../');
        $dotenv->load();
        
        $model = new Com\Gamelog\Models\UserModel();
        
        $username = "PCouce";

        $this->assertTrue($model->checkUserExists($username));
    }
}