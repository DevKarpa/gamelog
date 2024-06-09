<?php
use PHPUnit\Framework\TestCase;

class UserGamesModelTest extends TestCase {
    
    
    public function testCheckUserHasGame() {
        $dotenv = Dotenv\Dotenv::createImmutable('../');
        $dotenv->load();
        
        $model = new Com\Gamelog\Models\UserGamesModel();
        
        $gameID = 11; // ID del juego 'Celeste'
        $user = ["userID" => 14]; // ID del usuario "alex"

        $this->assertTrue($model->checkUserHasGame($gameID, $user));
        
    }
    
    public function testGetRegisterByID() {
        $dotenv = Dotenv\Dotenv::createImmutable('../');
        $dotenv->load();
        
        $model = new Com\Gamelog\Models\UserGamesModel();
        
        $gameID = 42; // ID del juego 'Farming Simulator 22'
        $user = ["userID" => 18]; // ID del usuario "PCouce"

        $this->assertIsArray($model->getRegisterByID($gameID, $user));
    }

}