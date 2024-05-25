<?php
use PHPUnit\Framework\TestCase;
require_once '../app/Models/UserModel.php';


class UserModelTest extends TestCase {
    
    
    public function testLoginUser() {
        $dotenv = Dotenv\Dotenv::createImmutable('../');
        $dotenv->load();
        
        $model = new Com\Daw2\Models\UserModel();
        
        $username = "alexTEST";
        $password = '1qazXSW"';

        $this->assertIsArray($model->loginUser($username, $password));
        
    }
    
    public function testCheckUserExists() {
        $dotenv = Dotenv\Dotenv::createImmutable('../');
        $dotenv->load();
        
        $model = new Com\Daw2\Models\UserModel();
        
        $username = "PCouceiro";

        $this->assertTrue($model->checkUserExists($username));
    }
}