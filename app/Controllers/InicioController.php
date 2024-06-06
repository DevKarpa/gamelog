<?php

namespace Com\Gamelog\Controllers;

class InicioController extends \Com\Gamelog\Core\BaseController {

    // Carga la página de inicio del administrador
    public function index() {
        $data = array(
            'titulo' => 'Administrator page',
            'breadcrumb' => ['adminindex']
        );        
        $this->view->showViews(array('templates/header.view.php', 'inicio.view.php', 'templates/footer.view.php'), $data);
    }
    
    // Carga la página de inicio del usuario no administrador
    public function userIndex() {
        $this->view->showViews(array('client/index.view.php'));
    }
    
    public function loadHelpPage(){
        $this->view->showViews(array('client/help.view.php'));
    }

}
