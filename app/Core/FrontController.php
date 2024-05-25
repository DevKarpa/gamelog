<?php

namespace Com\Daw2\Core;

use Steampixel\Route;

class FrontController {

    static function main() {
        // SI NO ESTÁ LOGEADO
        if (!isset($_SESSION['user'])) {

            Route::add('/login',
                    function () {
                        $controlador = new \Com\Daw2\Controllers\UserController();
                        $controlador->loginUser();
                    }
                    , 'get');

            Route::add('/login',
                    function () {
                        $controlador = new \Com\Daw2\Controllers\UserController();
                        $controlador->loginUser();
                    }
                    , 'post');

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
                    
            // PÁGINA DE AYUDA, TERMINOS Y CONDICIONES

            Route::add('/help',
                    function () {
                        $controlador = new \Com\Daw2\Controllers\InicioController();
                        $controlador->loadHelpPage();
                    }
                    , 'get');

            Route::add('/help',
                    function () {
                        $controlador = new \Com\Daw2\Controllers\InicioController();
                        $controlador->loadHelpPage();
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

            Route::add('/async/([a-z0-9 ]+)/([0-9]+)',
                    function ($txt,$id) {
                        $controlador = new \Com\Daw2\Controllers\GameController();
                        $controlador->asyncSearchGames($txt,$id);
                    }
                    , 'get');

            Route::add('/async/([a-z0-9 ]+)/([0-9]+)',
                    function ($txt,$id) {
                        $controlador = new \Com\Daw2\Controllers\GameController();
                        $controlador->asyncSearchGames($txt,$id);
                    }
                    , 'post');

            Route::add('/',
                    function () {
                        $controlador = new \Com\Daw2\Controllers\InicioController();
                        $controlador->userIndex();
                    }
                    , 'get');

            Route::pathNotFound(
                    function () {
                        $controlador = new \Com\Daw2\Controllers\InicioController();
                        $controlador->userIndex();
                    }
            );
            // SI ESTÁ LOGEADO
        } else {

            // SI ES ADMINISTRADOR
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

                Route::add('/dev-list/delete/([0-9]+)',
                        function ($id) {
                            $controlador = new \Com\Daw2\Controllers\DevController();
                            $controlador->deleteDev($id);
                        }
                        , 'get');

                Route::add('/dev-list/delete/([0-9]+)',
                        function ($id) {
                            $controlador = new \Com\Daw2\Controllers\DevController();
                            $controlador->deleteDev($id);
                        }
                        , 'post');

                Route::pathNotFound(
                        function () {
                            $controller = new \Com\Daw2\Controllers\ErroresController();
                            $controller->error404();
                        }
                );
                // SI NO ES ADMINISTRADOR
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
                        
                // PÁGINA DE AMIGOS 
                        
                Route::add('/profilefriends/([0-9]+)',
                        function ($id) {
                            $controlador = new \Com\Daw2\Controllers\UserController();
                            $controlador->showUserProfileFriends($id);
                        }
                        , 'get');

                Route::add('/profilefriends/([0-9]+)',
                        function ($id) {
                            $controlador = new \Com\Daw2\Controllers\UserController();
                            $controlador->showUserProfileFriends($id);
                        }
                        , 'post');
                        
                Route::add('/profilefriendsc/([0-9]+)',
                        function ($id) {
                            $controlador = new \Com\Daw2\Controllers\UserController();
                            $controlador->showUserProfileFriendsc($id);
                        }
                        , 'get');

                Route::add('/profilefriendsc/([0-9]+)',
                        function ($id) {
                            $controlador = new \Com\Daw2\Controllers\UserController();
                            $controlador->showUserProfileFriendsc($id);
                        }
                        , 'post');
                        
                Route::add('/unfollow/([0-9]+)',
                        function ($id) {
                            $controlador = new \Com\Daw2\Controllers\UserController();
                            $controlador->unfollowUser($id);
                        }
                        , 'get');

                Route::add('/unfollow/([0-9]+)',
                        function ($id) {
                            $controlador = new \Com\Daw2\Controllers\UserController();
                            $controlador->unfollowUser($id);
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

            Route::add('/async/([a-z0-9 ]+)/([0-9]+)',
                    function ($txt,$id) {
                        $controlador = new \Com\Daw2\Controllers\GameController();
                        $controlador->asyncSearchGames($txt,$id);
                    }
                    , 'get');

            Route::add('/async/([a-z0-9 ]+)/([0-9]+)',
                    function ($txt,$id) {
                        $controlador = new \Com\Daw2\Controllers\GameController();
                        $controlador->asyncSearchGames($txt,$id);
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

                Route::add('/addfriend/([0-9]+)',
                        function ($id) {
                            $controlador = new \Com\Daw2\Controllers\UserController();
                            $controlador->addFriend($id);
                        }
                        , 'get');

                Route::add('/addfriend/([0-9]+)',
                        function ($id) {
                            $controlador = new \Com\Daw2\Controllers\UserController();
                            $controlador->addFriend($id);
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
            
            // PÁGINA DE AYUDA, TERMINOS Y CONDICIONES

            Route::add('/help',
                    function () {
                        $controlador = new \Com\Daw2\Controllers\InicioController();
                        $controlador->loadHelpPage();
                    }
                    , 'get');

            Route::add('/help',
                    function () {
                        $controlador = new \Com\Daw2\Controllers\InicioController();
                        $controlador->loadHelpPage();
                    }
                    , 'post');

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
