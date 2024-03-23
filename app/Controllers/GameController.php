<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

class GameController extends \Com\Daw2\Core\BaseController {

    function showAllGames(): void {
        $gameModel = new \Com\Daw2\Models\GameModel();
        $data = [];
        $data['titulo'] = 'Lista de juegos';
        $data['seccion'] = 'game-list';
        $data['games'] = $gameModel->getAll();

        $this->view->showViews(array('templates/header.view.php', 'games.view.php', 'templates/footer.view.php'), $data);
    }

    function addGame(): void {
        $gameModel = new \Com\Daw2\Models\GameModel();
        $devModel = new \Com\Daw2\Models\DevModel();
        $data = [];
        $data['titulo'] = 'Add new game';
        $data['seccion'] = 'game-list';
        $data['games'] = $gameModel->getAll();
        $data['devs'] = $devModel->getAllDevs();

        $post = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);

        if (isset($post['submit'])) {
           // var_dump();
            $data['errores'] = $gameModel->addNewGame($post,$_FILES);
        }

        $this->view->showViews(array('templates/header.view.php', 'add.game.view.php', 'templates/footer.view.php'), $data);
    }
}
