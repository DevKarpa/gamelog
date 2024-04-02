<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

class UserGamesController extends \Com\Daw2\Core\BaseController {

    function addGameToCollection($id) {
        $gameModel = new \Com\Daw2\Models\GameModel();
        $userGamesModel = new \Com\Daw2\Models\UserGamesModel();
        $statusModel = new \Com\Daw2\Models\StatusModel();
        $data = [];
        $data['user'] = $_SESSION['user'];
        $data['game'] = $gameModel->getGameById($id);
        $data['statusList'] = $statusModel->getAllStatus();

        if (isset($_POST['submit'])) {
            $reg = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            if (count($this->checkRegValues($reg)) == 0) {
                $userGamesModel->addNewRegister($id, $reg, $data['user']);
            } else {
                $data['errors'] = $this->checkRegValues($reg);
            }
        }

        $this->view->showViews(array('client/addGame.view.php'), $data);
    }

    function editGameFromCollection($id) {
        $gameModel = new \Com\Daw2\Models\GameModel();
        $userGamesModel = new \Com\Daw2\Models\UserGamesModel();
        $statusModel = new \Com\Daw2\Models\StatusModel();
        $data = [];
        $data['user'] = $_SESSION['user'];
        $data['game'] = $gameModel->getGameById($id);
        $data['statusList'] = $statusModel->getAllStatus();
        $data['reg'] = $userGamesModel->getRegisterByID($id,$data['user']);

        if (isset($_POST['submit'])) {
            $reg = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            if (count($this->checkRegValues($reg)) == 0) {
                $userGamesModel->deleteGameRegister($id,$data['user']);
                $userGamesModel->addNewRegister($id, $reg, $data['user']);
            } else {
                $data['errors'] = $this->checkRegValues($reg);
            }
        }

        $this->view->showViews(array('client/addGame.view.php'), $data);
    }
    
    function deleteGameFromCollection($id) {
        $userGamesModel = new \Com\Daw2\Models\UserGamesModel();
        $user = $_SESSION['user'];
        $userGamesModel->deleteGameRegister($id, $user);
        header("location: /profile/" . $user['userID']);
    }

    // !! HACER MAS COMPROBACIONES TIPO: QUE LA FECHA INICIAL SEA ANTERIOR A LA FINAL
    function checkRegValues($reg): array {
        $statusModel = new \Com\Daw2\Models\StatusModel();
        $errors = [];

        // Comprueba si la fecha start es una fecha
        if ($reg['status'] != 1) {
            if (!strtotime($reg['start'])) {
                $errors['start'] = "La fecha inicial es obligatoria mientras no tengas el juego pendiente";
            }
        }

        // Comprueba si la fecha end es una fecha, siempre que status sea completed
        if ($reg['status'] == 3) {
            if (!strtotime($reg['end'])) {
                $errors['end'] = "La fecha de finalización es obligatoria si el juego ha sido completado.";
            }
        }

        if (!$statusModel->checkStatusExistsById($reg['status'])) {
            $errors['status'] = "Estado inválido";
        }

        return $errors;
    }
}
