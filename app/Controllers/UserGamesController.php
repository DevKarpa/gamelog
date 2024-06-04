<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

class UserGamesController extends \Com\Daw2\Core\BaseController {

    // Carga un juego nuevo a la colección
    function addGameToCollection($id) {
        $gameModel = new \Com\Daw2\Models\GameModel();
        $userGamesModel = new \Com\Daw2\Models\UserGamesModel();
        $statusModel = new \Com\Daw2\Models\StatusModel();
        $data = [];
        $data['user'] = $_SESSION['user'];
        $data['game'] = $gameModel->getGameById($id);
        $data['statusList'] = $statusModel->getAllStatus();
        $goToProfile = false;

        if (isset($_POST['submit'])) {
            $reg = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            if(isset($reg['fecha'])){
                $reg['fecha'] = explode(" - ", $reg['fecha']);
            
                $reg['fecha'][0] = $this->checkDateValues($reg)[0];
                $reg['fecha'][1] = $this->checkDateValues($reg)[1];
            }
            
            if (count($this->checkRegValues($reg)) == 0) {
                $userGamesModel->addNewRegister($id, $reg, $data['user']);
                $goToProfile = true;
            } else {
                $data['errors'] = $this->checkRegValues($reg);
            }
        }

        if(!$goToProfile){
            $this->view->showViews(array('client/addGame.view.php'), $data);
        }else{
            header("location: /profile/" . $_SESSION['user']['userID'] . "?page=1&order=0&status=4&add=" . $data['game']['gameID']);
        }
        
    }

    // Carga un juego de tu colección
    function editGameFromCollection($id) {
        $gameModel = new \Com\Daw2\Models\GameModel();
        $userGamesModel = new \Com\Daw2\Models\UserGamesModel();
        $statusModel = new \Com\Daw2\Models\StatusModel();
        $data = [];
        $data['user'] = $_SESSION['user'];
        $data['game'] = $gameModel->getGameById($id);
        $data['statusList'] = $statusModel->getAllStatus();
        $data['reg'] = $userGamesModel->getRegisterByID($id, $data['user']);
        $goToProfile = false;

        if (isset($_POST['submit'])) {
            
            $reg = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            if(isset($reg['fecha'])){
                $reg['fecha'] = explode(" - ", $reg['fecha']);

                $reg['fecha'][0] = $this->checkDateValues($reg)[0];
                $reg['fecha'][1] = $this->checkDateValues($reg)[1];
            }
            if (count($this->checkRegValues($reg)) == 0) {
                $userGamesModel->deleteGameRegister($id, $data['user']);
                $userGamesModel->addNewRegister($id, $reg, $data['user']);
                $goToProfile = true;
            } else {
                $data['errors'] = $this->checkRegValues($reg);
            }
        }

        if(!$goToProfile){
            $this->view->showViews(array('client/addGame.view.php'), $data);
        }else{
            header("location: /profile/" . $_SESSION['user']['userID'] . "?page=1&order=0&status=4&edit=" . $data['game']['gameID']);
        }
    }

    // Elimina un juego de tu colección
    function deleteGameFromCollection($id) {
        $userGamesModel = new \Com\Daw2\Models\UserGamesModel();
        $user = $_SESSION['user'];
        $userGamesModel->deleteGameRegister($id, $user);
        header("location: /profile/" . $user['userID'] . "?page=1&order=0&status=4&del=" . $data['game']['gameID']);
    }
    
    function checkDateValues($reg){
        $inicio = "";
        $fin = "";

        if(isset($reg['fecha'][0])){
            if($reg['fecha'][0]!="" || $reg['fecha'][0]!=null){
              $datei = str_replace('/', '-', $reg['fecha'][0]);
                $inicio = date('Y-m-d', strtotime($datei));  
            }
            
        }

        if(isset($reg['fecha'][1])){
            if($reg['fecha'][1]!="" || $reg['fecha'][1]!=null){
                $datef = str_replace('/', '-', $reg['fecha'][1]);
                $fin = date('Y-m-d', strtotime($datef));
            }
            
        }
        
        return [$inicio,$fin];
    }

    // Comprueba que los datos introducidos al añadir/editar juego de la colección,
    // sean coherentes.
    function checkRegValues($reg): array {
        $statusModel = new \Com\Daw2\Models\StatusModel();
        $errors = [];
        
        $inicio = (isset($reg['fecha'][0]) ? $reg['fecha'][0] : "");
        $fin = (isset($reg['fecha'][1]) ? $reg['fecha'][1] : "");

        if (!$statusModel->checkStatusExistsById($reg['status'])) {
            $errors['status'] = "Estado inválido";
        } else {
            // Si el juego ha sido cancelado
            if ($reg['status'] == 0) {
                if (!strtotime($inicio)) {
                    $errors['start'] = "La fecha inicial es obligatoria.";
                }

                if ($reg['note'] < 0 || $reg['note'] > 100){
                    $errors['note'] = "La nota debe estar comprendida entre 0 y 100";
                }
                
            }

            // Si el juego está pendiente
            if ($reg['status'] == 1) {
                if (strtotime($inicio)) {
                    $errors['start'] = "Si tienes el juego pendiente, no puedes haberlo iniciado.";
                }
                if (strtotime($fin)) {
                    $errors['end'] = "Si tienes el juego pendiente, no puedes haberlo finalizado.";
                }
                if ($reg['note']!=null){
                    $errors['note'] = "No puedes ponerle nota el juego si no lo has probado";
                }
            }

            // Si el juego está en progreso
            if ($reg['status'] == 2) {
                if (!strtotime($inicio)) {
                    $errors['start'] = "La fecha inicial es obligatoria si has empezado el juego.";
                }
                if (strtotime($fin)) {
                    $errors['end'] = "Si el juego sigue en progreso, no has podido terminarlo.";
                }
                if ($reg['note'] < 0 || $reg['note'] > 100){
                    $errors['note'] = "La nota debe estar comprendida entre 0 y 100";
                }
            }

            // Si el juego ha sido completado
            if ($reg['status'] == 3) {

                if (!strtotime($inicio)) {
                    $errors['start'] = "La fecha de inicio es obligatoria si el juego ha sido completado.";
                }
                if (!strtotime($fin)) {
                    $errors['end'] = "La fecha de finalización es obligatoria si el juego ha sido completado.";
                }
                if ($reg['note'] < 0 || $reg['note'] > 100){
                    $errors['note'] = "La nota debe estar comprendida entre 0 y 100";
                }
            }

        }

        return $errors;
    }
    
    function asyncSearchUserGames($txt,$id,$status) {
        $userGamesModel = new \Com\Daw2\Models\UserGamesModel();
        
        $games = $userGamesModel->getGamesByUserIDandStatus($id, $status);
        $i = 0;
        foreach ($games as $game) {
            if (str_contains(strtolower($game['gameTitle']), $txt)) {
                
            ?>
                <div class='game'>
                    <div class='gameContentLeft'>
                            <div class='gameImg'>
                                <?php echo "<img src='../assets/img/games/" . $game['gameID'] . ".png'>" ?>
                            </div>
                            <div class='gameText'>
                                <?php
                                    if(isset($game['nota'])){
                                        $class = ($game['nota']<=100 && $game['nota']>=81) ? "gnExcelent" : (($game['nota']<=80 && $game['nota']>=61) ? "gnGood" : (($game['nota']<=60 && $game['nota']>=40) ? "gnMixed" : (($game['nota']<=39 && $game['nota']>=0) ? "gnBad" : "")));
                                    }
                                ?>
                                <?php echo "<span class='gameTitle'>" . $game['gameTitle'] . (isset($game['nota']) ? "<span class='gameNote " . $class . "'>". $game['nota'] . "</span>" : '') . "</span>" ?>
                                <div class="gamePlat">
                                    <?php echo "<span>" . $game['platformName'] . "</span>" ?>
                                </div>
                                <div class="gameTime">
                                    <?php echo "<span>" . $game['fechaInicio'] . "</span>" ?>
                                    <?php echo "<span>" . $game['fechaFin'] . "</span>" ?>
                                </div>

                            </div>
                    </div>
                    <div class='gameContentRight'>
                        <?php echo "<span class='gameStatus'>" . $game['statusName'] . "</span>" ?>
                        <div class='gameButtons'>
                            <?php
                                if(isset($_SESSION['user'])){
                                    if ($_SESSION['user']['userID'] == $id) {
                                        echo "<a href='/edit/" . $game['gameID'] . "'><i class='fas fa-pen-square'></i></a>";
                                        echo "<a href='/delete/" . $game['gameID'] . "'><i class='fas fa-trash'></i></a>";
                                    }
                                }
                            ?>
                        </div>
                    </div>     
                </div>
            <?php
            }
            if ($i == 30) {
                break;
            }
            $i++;
        }
        
    }
}
