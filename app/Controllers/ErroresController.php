<?php
declare(strict_types = 1);
namespace Com\Gamelog\Controllers;

class ErroresController extends \Com\Gamelog\Core\BaseController {
    
    // Se encarga de cargar la vista referente al error 404
    function error404() : void{
       http_response_code(404);
       $data = ['titulo' => 'Error 404'];
       $data['error'] = '404. Página no encontrada';
       $this->view->showViews(array('error.php') , $data);
    }
    
    // Se encarga de cargar la vista referente al error 405
    function error405() : void{
       http_response_code(405);
       $data = ['titulo' => 'Error 405'];
       $data['error'] = '405. Método no permitido';
       
       $this->view->showViews(array('error.php') , $data);
    }
}