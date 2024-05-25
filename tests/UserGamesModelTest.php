<?php
use PHPUnit\Framework\TestCase;
require_once '../app/Models/UserGamesModel.php';


class UserGamesModelTest extends TestCase {
    
    
    public function testCheckUserHasGame() {
        $dotenv = Dotenv\Dotenv::createImmutable('../');
        $dotenv->load();
        
        $model = new Com\Daw2\Models\UserGamesModel();
        
        $gameID = 42; // ID del juego 'Farming Simulator 22'
        $user = ["userID" => 14]; // ID del usuario "alex"

        $this->assertTrue($model->checkUserHasGame($gameID, $user));
        
    }
    
    public function testGetRegisterByID() {
        $dotenv = Dotenv\Dotenv::createImmutable('../');
        $dotenv->load();
        
        $model = new Com\Daw2\Models\UserGamesModel();
        
        $gameID = 42; // ID del juego 'Farming Simulator 22'
        $user = ["userID" => 18]; // ID del usuario "PCouce"

        $this->assertIsArray($model->getRegisterByID($gameID, $user));
    }

}