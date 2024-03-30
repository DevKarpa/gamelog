<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

class GameController extends \Com\Daw2\Core\BaseController {

    function showAllGames(): void {
        $gameModel = new \Com\Daw2\Models\GameModel();
        $devModel = new \Com\Daw2\Models\DevModel();
        $platModel = new \Com\Daw2\Models\PlatformModel();
        $data = [];
        $data['titulo'] = 'Lista de juegos';
        $data['seccion'] = 'game-list';
        $data['devs'] = $devModel->getAllDevs();
        $data['platforms'] = $platModel->getAllPlatforms();
        
        if(isset($_POST["submit"])){
            $data['games'] = $gameModel->filterSearchGames($_POST);
        }else{
            $data['games'] = $gameModel->getAll();
        }

        $this->view->showViews(array('templates/header.view.php', 'games.view.php', 'templates/footer.view.php'), $data);
    }

    function addGame(): void {
        $gameModel = new \Com\Daw2\Models\GameModel();
        $devModel = new \Com\Daw2\Models\DevModel();
        $platModel = new \Com\Daw2\Models\PlatformModel();
        $data = [];
        $data['titulo'] = 'Add new game';
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
    
    function editGame($id) {
        $gameModel = new \Com\Daw2\Models\GameModel();
        $devModel = new \Com\Daw2\Models\DevModel();
        $platModel = new \Com\Daw2\Models\PlatformModel();
        $data = [];
        $data['titulo'] = 'Add new game';
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

    function checkGameErrors($metadata, $img) {
        $devModel = new \Com\Daw2\Models\DevModel();
        $platModel = new \Com\Daw2\Models\PlatformModel();
        $errors = [];
        echo (int) date("Y");
        // Comprobación de título del juego
        if (strlen($metadata['name']) > 30 || is_null($metadata['name'])) {
            $errors['name'] = "El título del juego debe tener una longitud de entre 1 y 30 carácteres.";
        }

        // Comprobación de año
        if (is_numeric($metadata['year'])) {
            // Si el año no se encuentra entre 1900 y el año actual
            if ($metadata['year'] < 1900 || $metadata['year'] > (int) date("Y")) {
                $errors['year'] = "El año debe estar compredido entre 1900 y el año actual.";
            }
        }
        
        // Comprobación de plataforma
        if(!$platModel->checkPlatformExists($metadata['platform'])){
            $errors['platform'] = "La plataforma introducida no existe";
        }
        
        // Comprobación de devs
        if(!$devModel->checkDevExists($metadata['devs'])){   
            $errors['platform'] = "La plataforma introducida no existe";
        }

        // Comprobación de imagen
        if(!is_null($this->checkGameImage($img))){
            $errors['image'] = $this->checkGameImage($img);
        }

        return $errors;
    }

    function checkGameImage($img) {
        $upload = true;
        
        $check = getimagesize($img["image"]["tmp_name"]);
        if ($check === false) {
            $error = "Tipo de archivo no compatible";
            $upload = false;
        }
        
        if(!$upload){
            return $error;
        }

    }
    
    function deleteGame($id) {
        $gameModel = new \Com\Daw2\Models\GameModel();
        $deletedGame = $gameModel->getGameById($id)['gameTitle'];

        $data = [];
        $data['titulo'] = 'Lista de juegos';
        $data['seccion'] = 'game-list';
        $data['deletedGame'] = $deletedGame;
        $gameModel->deleteGameById($id);
        $data['games'] = $gameModel->getAll();

        $this->view->showViews(array('templates/header.view.php', 'games.view.php', 'templates/footer.view.php'), $data);
    }
}
