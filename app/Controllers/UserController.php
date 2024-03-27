<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

class UserController extends \Com\Daw2\Core\BaseController {

    function loginUser(): void {
        $userModel = new \Com\Daw2\Models\UserModel();
        $user = null;
        $data = [];

        $loginData = $_POST;
        if (isset($loginData['username']) && isset($loginData['pass'])) {
            if ($userModel->loginUser($loginData['username'], $loginData['pass'])) {
                $user = $userModel->loginUser($loginData['username'], $loginData['pass']);
                $_SESSION['user'] = $user;
            } else {
                $data['error'] = "Datos incorrectos";
            }

        }
        
        if(!is_null($user)){
            header("location: /");
        }else{
            $this->view->showViews(array('login.view.php'), $data);
        }
        
    }
    
    function registerUser(): void {
        $userModel = new \Com\Daw2\Models\UserModel();
        $data = [];
        $data['register'] = true;

        $this->view->showViews(array('login.view.php'), $data);
        
    }
    
    function logout() {
        session_destroy();
        header("location: /");
    }
    
    function showAllUsers() {
        $userModel = new \Com\Daw2\Models\UserModel();
        $data = [];
        $data['titulo'] = 'Lista de usuarios';
        $data['seccion'] = 'user-list';
        $data['users'] = $userModel->getAllUsers();

        $this->view->showViews(array('templates/header.view.php', 'users.view.php', 'templates/footer.view.php'), $data);
    }
}
