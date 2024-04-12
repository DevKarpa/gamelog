<?php

namespace Com\Daw2\Core;

use Steampixel\Route;

class FrontController {

    static function main() {

        if (!isset($_SESSION['user'])) {

            Route::add('/',
                    function () {
                        $controlador = new \Com\Daw2\Controllers\UserController();
                        $controlador->loginUser();
                    }
                    , 'get');
                    
            Route::add('/register',
                    function () {
                        $controlador = new \Com\Daw2\Controllers\UserController();
                        $controlador->registerUser();
                    }
                    , 'get');
                    
            Route::add('/register',
                    function () {
                        $controlador = new \Com\Daw2\Controllers\UserController();
                        $controlador->registerUser();
                    }
                    , 'post');

            Route::pathNotFound(
                    function () {
                        $controller = new \Com\Daw2\Controllers\UserController();
                        $controller->loginUser();
                    }
            );
        } else {

            if ($_SESSION['user']['userType'] == 1) {

                Route::add('/',
                        function () {
                            $controlador = new \Com\Daw2\Controllers\InicioController();
                            $controlador->index();
                        }
                        , 'get');

                // LISTA DE JUEGOS
                Route::add('/game-list',
                        function () {
                            $controlador = new \Com\Daw2\Controllers\GameController();
                            $controlador->showAllGames();
                        }
                        , 'get');

                Route::add('/game-list',
                        function () {
                            $controlador = new \Com\Daw2\Controllers\GameController();
                            $controlador->showAllGames();
                        }
                        , 'post');
                        
                Route::add('/game-list',
                        function () {
                            $controlador = new \Com\Daw2\Controllers\GameController();
                            $controlador->addGame();
                        }
                        , 'post');

                Route::add('/game-list/add',
                        function () {
                            $controlador = new \Com\Daw2\Controllers\GameController();
                            $controlador->addGame();
                        }
                        , 'get');
                        
                Route::add('/game-list/add',
                        function () {
                            $controlador = new \Com\Daw2\Controllers\GameController();
                            $controlador->addGame();
                        }
                        , 'post');
                        
                Route::add('/game-list/edit/([0-9]+)',
                        function ($id) {
                            $controlador = new \Com\Daw2\Controllers\GameController();
                            $controlador->editGame($id);
                        }
                        , 'get');
                        
                Route::add('/game-list/edit/([0-9]+)',
                        function ($id) {
                            $controlador = new \Com\Daw2\Controllers\GameController();
                            $controlador->editGame($id);
                        }
                        , 'post');
                        
                Route::add('/game-list/delete/([0-9]+)',
                        function ($id) {
                            $controlador = new \Com\Daw2\Controllers\GameController();
                            $controlador->deleteGame($id);
                        }
                        , 'get');
                        
                Route::add('/game-list/delete/([0-9]+)',
                        function ($id) {
                            $controlador = new \Com\Daw2\Controllers\GameController();
                            $controlador->deleteGame($id);
                        }
                        , 'post');

                        
                // LISTA DE USUARIOS
                Route::add('/user-list',
                        function () {
                            $controlador = new \Com\Daw2\Controllers\UserController();
                            $controlador->showAllUsers();
                        }
                        , 'post');
                        
                Route::add('/user-list',
                        function () {
                            $controlador = new \Com\Daw2\Controllers\UserController();
                            $controlador->showAllUsers();
                        }
                        , 'get');
                        
                Route::add('/user-list/delete/([0-9]+)',
                        function ($id) {
                            $controlador = new \Com\Daw2\Controllers\UserController();
                            $controlador->deleteUser($id);
                        }
                        , 'get');
                        
                Route::add('/user-list/delete/([0-9]+)',
                        function ($id) {
                            $controlador = new \Com\Daw2\Controllers\UserController();
                            $controlador->deleteUser($id);
                        }
                        , 'post');
                        
                Route::add('/user-list/edit/([0-9]+)',
                        function ($id) {
                            $controlador = new \Com\Daw2\Controllers\UserController();
                            $controlador->editUser($id);
                        }
                        , 'get');
                        
                Route::add('/user-list/edit/([0-9]+)',
                        function ($id) {
                            $controlador = new \Com\Daw2\Controllers\UserController();
                            $controlador->editUser($id);
                        }
                        , 'post');
                        
                // LISTA DE DEVS
                        
                Route::add('/dev-list',
                        function () {
                            $controlador = new \Com\Daw2\Controllers\DevController();
                            $controlador->showAllDevs();
                        }
                        , 'get');

                Route::add('/dev-list',
                        function () {
                            $controlador = new \Com\Daw2\Controllers\DevController();
                            $controlador->showAllDevs();
                        }
                        , 'post');

                Route::add('/dev-list/add',
                        function () {
                            $controlador = new \Com\Daw2\Controllers\DevController();
                            $controlador->addDev();
                        }
                        , 'get');
                        
                Route::add('/dev-list/add',
                        function () {
                            $controlador = new \Com\Daw2\Controllers\DevController();
                            $controlador->addDev();
                        }
                        , 'post');
                        
                Route::pathNotFound(
                    function () {
                        $controller = new \Com\Daw2\Controllers\ErroresController();
                        $controller->error404();
                    }
            );

            } else {
                
                // PÁGINA PRINCIPAL
                
                Route::add('/',
                        function () {
                            $controlador = new \Com\Daw2\Controllers\InicioController();
                            $controlador->userIndex();
                        }
                        , 'get');
                        
                // PÁGINA DE PERFIL
                        
                Route::add('/profile/([0-9]+)',
                        function ($id) {
                            $controlador = new \Com\Daw2\Controllers\UserController();
                            $controlador->showUserProfile($id);
                        }
                        , 'get');
                        
                Route::add('/profile/([0-9]+)',
                        function ($id) {
                            $controlador = new \Com\Daw2\Controllers\UserController();
                            $controlador->showUserProfile($id);
                        }
                        , 'post');
                        
                // BUSCADOR DE JUEGOS, CON BOTÓN DE AÑADIR (AL PERFIL LOGEADO)
                        
                Route::add('/search',
                        function () {
                            $controlador = new \Com\Daw2\Controllers\GameController();
                            $controlador->searchGames();
                        }
                        , 'get');
                        
                Route::add('/search',
                        function () {
                            $controlador = new \Com\Daw2\Controllers\GameController();
                            $controlador->searchGames();
                        }
                        , 'post');
                        
                // VISTA PARA CONTROLAR ASINCRONISMO AL BUSCAR JUEGOS
                        
                Route::add('/async/([a-z0-9 ]+)',
                        function ($txt) {
                            $controlador = new \Com\Daw2\Controllers\GameController();
                            $controlador->asyncSearchGames($txt);
                        }
                        , 'get');
                        
                Route::add('/async/([a-z0-9 ]+)',
                        function ($txt) {
                            $controlador = new \Com\Daw2\Controllers\GameController();
                            $controlador->asyncSearchGames($txt);
                        }
                        , 'post');
                        
                // EDITAR DATOS DEL USUARIO LOGEADO
                        
                Route::add('/settings',
                        function () {
                            $controlador = new \Com\Daw2\Controllers\UserController();
                            $controlador->editCurrentUser();
                        }
                        , 'get');
                        
                Route::add('/settings',
                        function () {
                            $controlador = new \Com\Daw2\Controllers\UserController();
                            $controlador->editCurrentUser();
                        }
                        , 'post');
                        
               // VISTA DE AÑADIR JUEGO A LA COLECCIÓN
                
               Route::add('/add/([0-9]+)',
                        function ($id) {
                            $controlador = new \Com\Daw2\Controllers\UserGamesController();
                            $controlador->addGameToCollection($id);
                        }
                        , 'get');
                        
                Route::add('/add/([0-9]+)',
                        function ($id) {
                            $controlador = new \Com\Daw2\Controllers\UserGamesController();
                            $controlador->addGameToCollection($id);
                        }
                        , 'post');
                        
               // VISTA DE EDITAR JUEGO DE LA COLECCIÓN
                
               Route::add('/edit/([0-9]+)',
                        function ($id) {
                            $controlador = new \Com\Daw2\Controllers\UserGamesController();
                            $controlador->editGameFromCollection($id);
                        }
                        , 'get');
                        
                Route::add('/edit/([0-9]+)',
                        function ($id) {
                            $controlador = new \Com\Daw2\Controllers\UserGamesController();
                            $controlador->editGameFromCollection($id);
                        }
                        , 'post');
                        
                // ELIMINAR JUEGO DE COLECCIÓN
                
               Route::add('/delete/([0-9]+)',
                        function ($id) {
                            $controlador = new \Com\Daw2\Controllers\UserGamesController();
                            $controlador->deleteGameFromCollection($id);
                        }
                        , 'get');
                        
                Route::add('/delete/([0-9]+)',
                        function ($id) {
                            $controlador = new \Com\Daw2\Controllers\UserGamesController();
                            $controlador->deleteGameFromCollection($id);
                        }
                        , 'post');
                
                        
            }

            Route::add('/logout',
                    function () {
                        $controlador = new \Com\Daw2\Controllers\UserController();
                        $controlador->logout();
                    }
                    , 'get');

            Route::methodNotAllowed(
                    function () {
                        $controller = new \Com\Daw2\Controllers\ErroresController();
                        $controller->error405();
                    }
            );
        }


        Route::run();
    }
}
