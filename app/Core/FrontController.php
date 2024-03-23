<?php

namespace Com\Daw2\Core;

use Steampixel\Route;

class FrontController{
    
    static function main(){
        Route::add('/', 
                function(){
                    $controlador = new \Com\Daw2\Controllers\InicioController();
                    $controlador->index();
                }
                , 'get');
        
        Route::add('/game-list', 
                function(){
                    $controlador = new \Com\Daw2\Controllers\GameController();
                    $controlador->showAllGames();
                }
                , 'get');
                
        Route::add('/game-list', 
                function(){
                    $controlador = new \Com\Daw2\Controllers\GameController();
                    $controlador->showAllGames();
                }
                , 'post');
                
        Route::add('/game-list/add', 
                function(){
                    $controlador = new \Com\Daw2\Controllers\GameController();
                    $controlador->addGame();
                }
                , 'get');
                
        Route::add('/game-list/add', 
                function(){
                    $controlador = new \Com\Daw2\Controllers\GameController();
                    $controlador->addGame();
                }
                , 'post');
                
        Route::pathNotFound(
            function(){
                $controller = new \Com\Daw2\Controllers\ErroresController();
                $controller->error404();
            }
        );
        
        Route::methodNotAllowed(
            function(){
                $controller = new \Com\Daw2\Controllers\ErroresController();
                $controller->error405();
            }
        );
        Route::run();
    }
}

