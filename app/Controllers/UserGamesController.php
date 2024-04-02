<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

class UserGamesController extends \Com\Daw2\Core\BaseController {

    function addGameToCollection($id) {
        $gameModel = new \Com\Daw2\Models\GameModel();
        $userGamesModel = new \Com\Daw2\Models\UserGamesModel();

        //if (!$userGamesModel->checkUserHasGame($id, $_SESSION['user'])) {
            $data = [];
            $data['user'] = $_SESSION['user'];
            $data['game'] = $gameModel->getGameById($id);

            if (isset($_POST['submit'])) {
                $reg = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
                if (count($this->checkRegValues($reg)) == 0) {
                    $userGamesModel->addNewRegister($id, $reg, $data['user']);
                } else {
                    $data['errors'] = $this->checkRegValues($reg);
                }
            }

            $this->view->showViews(array('client/addGame.view.php'), $data);
       // } else {
       //     $this->editGameFromCollection($id);
       // }
    }

    function editGameFromCollection($id) {
        $data = [];
        $data['user'] = $_SESSION['user'];
        $data['game'] = $gameModel->getGameById($id);

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
