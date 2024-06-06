<?php
require '../vendor/autoload.php';
        
try{
    session_start();
    $dotenv = Dotenv\Dotenv::createImmutable('../');
    $dotenv->load();
    Com\Gamelog\Core\FrontController::main();    
} catch (Exception $e) {
    echo $e->getMessage();
}