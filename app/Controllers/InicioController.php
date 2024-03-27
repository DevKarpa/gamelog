<?php

namespace Com\Daw2\Controllers;

class InicioController extends \Com\Daw2\Core\BaseController {

    public function index() {
        $data = array(
            'titulo' => 'Administrator page',
            'breadcrumb' => ['adminindex']
        );        
        $this->view->showViews(array('templates/header.view.php', 'inicio.view.php', 'templates/footer.view.php'), $data);
    }
    
    public function userIndex() {
        $this->view->showViews(array('client/index.view.php'));
    }

}
