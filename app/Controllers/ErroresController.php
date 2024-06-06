<?php
declare(strict_types = 1);
namespace Com\Gamelog\Controllers;

class ErroresController extends \Com\Gamelog\Core\BaseController {
    
    // Se encarga de cargar la vista referente al error 404
    function error404() : void{
       http_response_code(404);
       $data = ['titulo' => 'Error 404'];
       $data['texto'] = '404. File not found';
       $this->view->showViews(array('templates/header.view.php', 'error.php', 'templates/footer.view.php') , $data);
    }
    
    // Se encarga de cargar la vista referente al error 405
    function error405() : void{
       http_response_code(405);
       $data = ['titulo' => 'Error 405'];
       $data['texto'] = '405. Method not allowed';
       
       $this->view->showViews(array('templates/header.view.php', 'error.php', 'templates/footer.view.php') , $data);
    }
}