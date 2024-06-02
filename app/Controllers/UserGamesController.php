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
            header("location: /profile/" . $_SESSION['user']['userID'] . "?page=1");
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
            header("location: /profile/" . $_SESSION['user']['userID'] . "?page=1");
        }
    }

    // Elimina un juego de tu colección
    function deleteGameFromCollection($id) {
        $userGamesModel = new \Com\Daw2\Models\UserGamesModel();
        $user = $_SESSION['user'];
        $userGamesModel->deleteGameRegister($id, $user);
        header("location: /profile/" . $user['userID'] . "?page=1");
    }

    // Comprueba que los datos introducidos al añadir/editar juego de la colección,
    // sean coherentes.
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
                if ($reg['note'] < 0 || $reg['note'] > 100){
                    $errors['note'] = "La nota debe estar comprendida entre 0 y 100";
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
                if ($reg['note']!=null){
                    $errors['note'] = "No puedes ponerle nota el juego si no lo has probado";
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
                if ($reg['note'] < 0 || $reg['note'] > 100){
                    $errors['note'] = "La nota debe estar comprendida entre 0 y 100";
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
                if ($reg['note'] < 0 || $reg['note'] > 100){
                    $errors['note'] = "La nota debe estar comprendida entre 0 y 100";
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
