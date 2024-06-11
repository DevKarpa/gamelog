<?php

declare(strict_types=1);

namespace Com\Gamelog\Controllers;

class GameController extends \Com\Gamelog\Core\BaseController {

    // Guarda todos los juegos, les aplica paginación y filtros y los muestra
    // en la vista.
    function showAllGames(): void {
        $gameModel = new \Com\Gamelog\Models\GameModel();
        $devModel = new \Com\Gamelog\Models\DevModel();
        $platModel = new \Com\Gamelog\Models\PlatformModel();
        $data = [];
        $offset = null;
        $data['titulo'] = 'Lista de juegos';
        $data['seccion'] = 'game-list';
        $data['allgames'] = $gameModel->getAll();
        $data['devs'] = $devModel->getAllDevs();
        $data['platforms'] = $platModel->getAllPlatforms();
        $data['maxpage'] = ceil(count($data['allgames']) / 5);

        if (isset($_GET['page'])) {
            $data['page'] = $_GET['page'];
            $offset = ($data['page'] - 1) * 5;
        }

        if (isset($_POST["submit"])) {
            $data['games'] = $gameModel->filterSearchGames($_POST, $offset);
        } else {
            if (isset($_GET['page'])) {
                $data['games'] = $gameModel->getPageGames($offset);
            } else {
                $data['games'] = $gameModel->getAll();
            }
        }
        
        if(isset($_GET['del'])){
            $gameModel->deleteGameById($_GET['del']);
        }

        $this->view->showViews(array('templates/header.view.php', 'games.view.php', 'templates/footer.view.php'), $data);
    }

    // Añade juego a la base de datos, siempre que no tenga errores.
    function addGame(): void {
        $gameModel = new \Com\Gamelog\Models\GameModel();
        $devModel = new \Com\Gamelog\Models\DevModel();
        $platModel = new \Com\Gamelog\Models\PlatformModel();
        $data = [];
        $data['titulo'] = 'Añadir nuevo juego';
        $data['seccion'] = 'game-list';
        $data['games'] = $gameModel->getAll();
        $data['devs'] = $devModel->getAllDevs();
        $data['platforms'] = $platModel->getAllPlatforms();

        $post = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
        
        if (isset($post['submit'])) {
            
            $data['errores'] = $this->checkGameErrors($post, $_FILES);

            if (count($data['errores']) == 0) {
                $gameModel->saveNewGame($post, $_FILES);
            }
        }

        $this->view->showViews(array('templates/header.view.php', 'add.game.view.php', 'templates/footer.view.php'), $data);
    }

    // Edita un juego ya existente, comprobando que no tenga fallos
    function editGame($id) {
        $gameModel = new \Com\Gamelog\Models\GameModel();
        $devModel = new \Com\Gamelog\Models\DevModel();
        $platModel = new \Com\Gamelog\Models\PlatformModel();
        $data = [];
        $data['titulo'] = 'Editar juego';
        $data['seccion'] = 'game-list';
        $data['games'] = $gameModel->getAll();
        $data['devs'] = $devModel->getAllDevs();
        $data['platforms'] = $platModel->getAllPlatforms();
        $data['input'] = $gameModel->getGameById($id);
        $data['inputd'] = $devModel->getDevGamesById($id);

        $post = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);

        if (isset($post['submit'])) {
            $data['errores'] = $this->checkGameErrors($post, $_FILES);

            if (count($data['errores']) == 0) {
                $gameModel->modifyGameData($post, $_FILES, $id);
            }
        }

        $this->view->showViews(array('templates/header.view.php', 'add.game.view.php', 'templates/footer.view.php'), $data);
    }

    // Comprueba que los datos introducidos al añadir/editar juego, están correctos.
    function checkGameErrors($metadata, $img) {
        $devModel = new \Com\Gamelog\Models\DevModel();
        $platModel = new \Com\Gamelog\Models\PlatformModel();
        $errors = [];

        // Comprobación de título del juego
        if (strlen($metadata['name']) > 60 || is_null($metadata['name'])) {
            $errors['name'] = "El título del juego debe tener una longitud de entre 1 y 60 carácteres.";
        }

        // Comprobación de año
        if (is_numeric($metadata['year'])) {
            // Si el año no se encuentra entre 1900 y el año actual
            if ($metadata['year'] < 1900 || $metadata['year'] > (int) date("Y")) {
                $errors['year'] = "El año debe estar compredido entre 1900 y el año actual.";
            }
        }

        // Comprobación de plataforma
        if (!$platModel->checkPlatformExists($metadata['platform'])) {
            $errors['platform'] = "La plataforma introducida no existe";
        }

        // Comprobación de devs
        if (!$devModel->checkDevExists($metadata['devs'])) {
            $errors['platform'] = "La plataforma introducida no existe";
        }

        // Comprobación de imagen
        if (!is_null($this->checkGameImage($img))) {
            $errors['image'] = $this->checkGameImage($img);
        }

        return $errors;
    }

    // Comprueba que el archivo subido se trata de una imagen
    function checkGameImage($img) {
        $upload = true;

        $check = getimagesize($img["image"]["tmp_name"]);
        if ($check === false) {
            $error = "Tipo de archivo no compatible";
            $upload = false;
        }

        if (!$upload) {
            return $error;
        }
    }

    // Elimina el juego de la base de datos
    function deleteGame($id) {
        
        header("location: /game-list?page=1&del=" . $id);
        
    }

    // FUNCIONES USADAS PARA LA VISTA DEL USUARIO NO ADMINISTRADOR
    // Carga la vista principal de /search
    function searchGames(): void {
        $platModel = new \Com\Gamelog\Models\PlatformModel();
        $data['platforms'] = $platModel->getAllPlatforms();
        $this->view->showViews(array('client/games.view.php'), $data);
    }

    // Función que se ejecuta de forma asíncrona, y va mostrando los juegos que coinciden con
    // el texto pasado por parámetro
    function asyncSearchGames($txt, $id) {
        
        if(strlen($txt)>=3){

            $gameModel = new \Com\Gamelog\Models\GameModel();
            $userGamesModel = new \Com\Gamelog\Models\UserGamesModel();

            if (isset($_SESSION['user'])) {
                $userGames = $userGamesModel->getGamesIDByUserID($_SESSION['user']['userID']);
            }

            $games = $gameModel->getAll();


            foreach ($games as $game) {
                if (str_contains(strtolower($game['gameTitle']), $txt)) {
                    // Si el id de plataforma es distinto de 0, muestra juegos de todas las plataformas, sino
                    // solo muestra el juego de la plataforma correspondiente.
                    if ($id != 0) {
                        if ($id == $game['platformID']) {
                            echo "<div class='game'>
                                    <div class='gameContentLeft'>
                                            <div class='gameImg'>
                                                <img src='assets/img/games/" . $game['gameID'] . ".png'>
                                            </div>
                                            <div class='gameText'>
                                                <span class='gameTitle'>" . $game['gameTitle'] . "</span>
                                                <span class='gamePlat'>" . $game['platformName'] . "</span>
                                            </div>
                                        </div>
                                    <div class='gameContentRight'>
                                            <span class='gameYear'>" . $game['gameYear'] . "</span>
                                            <div class='gameButtons'>";


                            if (isset($_SESSION['user'])) {
                                echo "<a href='/" . (in_array($game['gameID'], $userGames) ? 'edit' : 'add') . "/" . $game['gameID'] . "'>" . (in_array($game['gameID'], $userGames) ? '<i class="fas fa-pen-square"></i>' : '<i class="fas fa-plus-square"></i>') . "</a>";
                            }
                            echo "</div></div></div>";
                        }
                    } else {
                        echo "<div class='game'>
                                    <div class='gameContentLeft'>
                                            <div class='gameImg'>
                                                <img src='assets/img/games/" . $game['gameID'] . ".png'>
                                            </div>
                                            <div class='gameText'>
                                                <span class='gameTitle'>" . $game['gameTitle'] . "</span>
                                                <span class='gamePlat'>" . $game['platformName'] . "</span>
                                            </div>
                                        </div>
                                    <div class='gameContentRight'>
                                            <span class='gameYear'>" . $game['gameYear'] . "</span>
                                            <div class='gameButtons'>";


                            if (isset($_SESSION['user'])) {
                                echo "<a href='/" . (in_array($game['gameID'], $userGames) ? 'edit' : 'add') . "/" . $game['gameID'] . "'>" . (in_array($game['gameID'], $userGames) ? '<i class="fas fa-pen-square"></i>' : '<i class="fas fa-plus-square"></i>') . "</a>";
                            }
                            echo "</div></div></div>";

                    }
                }
            
            }
        }else{
            echo "Introduce al menos 3 caracteres.";
        }
    }
}
