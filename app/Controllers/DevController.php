<?php

declare(strict_types=1);

namespace Com\Gamelog\Controllers;

class DevController extends \Com\Gamelog\Core\BaseController {

    // Guarda datos de todos los devs ordenados para mostrarlos en la vista
    function showAllDevs(): void {
        $devModel = new \Com\Gamelog\Models\DevModel();
        $data = [];
        $data['titulo'] = 'Lista de devs';
        $data['seccion'] = 'dev-list';
        $data['devs'] = $devModel->getAllDevsIDordered();

        $this->view->showViews(array('templates/header.view.php', 'devs.view.php', 'templates/footer.view.php'), $data);
    }
    
    // Añade devs a la base de datos siempre que este no exista
    function addDev() {
        $devModel = new \Com\Gamelog\Models\DevModel();
        $data = [];
        $data['titulo'] = 'Añadir desarrolladores';
        $data['seccion'] = 'dev-list';
        $data['devs'] = $devModel->getAllDevsIDordered();
        
        if(isset($_POST['submit'])){
            $data['errores'] = [];
            if(isset($_POST['devs'])){
                $devs = filter_var_array($_POST['devs'],FILTER_SANITIZE_SPECIAL_CHARS);
                $data['errores'] = $devModel->checkDevExistsByName($devs);
                if(count($data['errores'])==0){
                    $devModel->addNewDevs($devs);
                }else{
                    $data['inputDevs'] = $devs;
                }
            }
        }

        $this->view->showViews(array('templates/header.view.php', 'add.devs.view.php', 'templates/footer.view.php'), $data);
    }
    
    // Elimina el dev con el id pasado por parámetro 
    function deleteDev($id) {
        $gameModel = new \Com\Gamelog\Models\GameModel();
        $devModel = new \Com\Gamelog\Models\DevModel();
        $deletedDev = $devModel->getDevById($id);

        $data = [];
        $data['titulo'] = 'Lista de devs';
        $data['seccion'] = 'dev-list';
        $data['deletedDev'] = $deletedDev;
        $devModel->deleteDevFromGame($id);
        $devModel->deleteDevById($id);
        $data['devs'] = $devModel->getAllDevsIDordered();

        $this->view->showViews(array('templates/header.view.php', 'devs.view.php', 'templates/footer.view.php'), $data);
    }

}
