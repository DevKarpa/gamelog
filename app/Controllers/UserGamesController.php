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
        $data['reg'] = $userGamesModel->getRegisterByID($id, $data['user']);

        if (isset($_POST['submit'])) {
            $reg = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            if (count($this->checkRegValues($reg)) == 0) {
                $userGamesModel->deleteGameRegister($id, $data['user']);
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

    function checkRegValues($reg): array {
        $statusModel = new \Com\Daw2\Models\StatusModel();
        $errors = [];

        if (!$statusModel->checkStatusExistsById($reg['status'])) {
            $errors['status'] = "Estado inválido";
        } else {
            // Si el juego ha sido cancelado
            if ($reg['status'] == 0) {
                if (!strtotime($reg['start'])) {
                    $errors['start'] = "La fecha inicial es obligatoria.";
                }
                if (strtotime($reg['end'])) {
                    $errors['end'] = "Si el juego ha sido cancelado, no has podido terminarlo";
                }
            }

            // Si el juego está pendiente
            if ($reg['status'] == 1) {
                if (strtotime($reg['start'])) {
                    $errors['start'] = "Si tienes el juego pendiente, no puedes haberlo iniciado.";
                }
                if (strtotime($reg['end'])) {
                    $errors['end'] = "Si tienes el juego pendiente, no puedes haberlo finalizado.";
                }
            }

            // Si el juego está en progreso
            if ($reg['status'] == 2) {
                if (!strtotime($reg['start'])) {
                    $errors['start'] = "La fecha inicial es obligatoria si has empezado el juego.";
                }
                if (strtotime($reg['end'])) {
                    $errors['end'] = "Si el juego sigue en progreso, no has podido terminarlo.";
                }
            }

            // Si el juego ha sido completado
            if ($reg['status'] == 3) {
                if (!strtotime($reg['end'])) {
                    $errors['end'] = "La fecha de finalización es obligatoria si el juego ha sido completado.";
                }
                if (!strtotime($reg['start'])) {
                    $errors['start'] = "La fecha de inicio es obligatoria si el juego ha sido completado.";
                }
            }
            
            // Comprueba que la fecha de inicio sea antes que la de finalización
            if(strtotime($reg['start'])&&strtotime($reg['end'])){
                if($reg['start']>$reg['end']){
                    $errors['logic'] = "La fecha de inicio no puede ser superior a la de finalización";
                }
            }
        }

        return $errors;
    }
}
