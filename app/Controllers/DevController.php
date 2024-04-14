<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

class DevController extends \Com\Daw2\Core\BaseController {

    function showAllDevs(): void {
        $devModel = new \Com\Daw2\Models\DevModel();
        $data = [];
        $data['titulo'] = 'Lista de devs';
        $data['seccion'] = 'dev-list';
        $data['devs'] = $devModel->getAllDevsIDordered();

        $this->view->showViews(array('templates/header.view.php', 'devs.view.php', 'templates/footer.view.php'), $data);
    }
    
    function addDev() {
        $devModel = new \Com\Daw2\Models\DevModel();
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
                }
            }
        }

        $this->view->showViews(array('templates/header.view.php', 'add.devs.view.php', 'templates/footer.view.php'), $data);
    }
    
    function deleteDev($id) {
        $gameModel = new \Com\Daw2\Models\GameModel();
        $devModel = new \Com\Daw2\Models\DevModel();
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
