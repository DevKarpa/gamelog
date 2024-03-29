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

        if (!is_null($user)) {
            header("location: /");
        } else {
            $this->view->showViews(array('login.view.php'), $data);
        }
    }

    function registerUser(): void {
        $userModel = new \Com\Daw2\Models\UserModel();
        $data = [];
        $data['register'] = true;

        if (isset($_POST['submit'])) {
            if (isset($_POST['username']) && isset($_POST['pass']) && isset($_POST['pass2'])) {
                var_dump(count($this->checkRegisterData($_POST)));
                if (count($this->checkRegisterData($_POST)) == 0) {
                    $_SESSION['user'] = $userModel->registerUser($_POST);
                    header("location: /");
                } else {
                    $data['errors'] = $this->checkRegisterData($_POST);
                }
            } else {
                $data['error'] = "Rellena todas las casillas";
            }
        }

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

    function checkRegisterData($data): array {
        $errors = [];
        $userModel = new \Com\Daw2\Models\UserModel();

        // Comprobación de username, si existe ya en la base de datos, o si no cuenta con la longitud correcta.
        if (!$userModel->checkUserExists($data['username'])) {
            if (strlen($data['username']) < 4 || strlen($data['username']) > 16) {
                $errors['username'] = "El nombre de usuario debe tener una longitud de entre 4 y 16 caracteres.";
            }
        } else {
            $errors['username'] = "El nombre de usuario ya está registrado";
        }

        // Comprobación de contraseña
        //var_dump($this->checkUserPassword($data['pass'],$data['pass2']));
        if ($this->checkUserPassword($data['pass'], $data['pass2']) !== null) {
            $errors['password'] = $this->checkUserPassword($data['pass'], $data['pass2']);
        }


        return $errors;
    }

    function checkUserPassword($pass, $pass2): ?array {
        $errors = [];

        if ($pass == $pass2) {

            if (strlen($pass) < 8) {
                $errors[] = "Las contraseña debe tener mas de 8 caracteres.";
            }

            if (!preg_match("([A-Z]+)", $pass)) {
                $errors[] = "Las contraseña debe contener mayúsculas.";
            }

            if (!preg_match("([a-z]+)", $pass)) {
                $errors[] = "Las contraseña debe contener minúsculas.";
            }

            if (!preg_match("([0-9]+)", $pass)) {
                $errors[] = "Las contraseña debe algún número.";
            }
        } else {
            $errors[] = "Las contraseñas deben coincidir.";
        }

        if (count($errors) == 0) {
            return null;
        }

        return $errors;
    }

    function deleteUser($id) {
        $userModel = new \Com\Daw2\Models\UserModel();
        $deletedUser = $userModel->getUserById($id);

        $data = [];
        $data['titulo'] = 'Lista de usuarios';
        $data['seccion'] = 'user-list';

        if ($deletedUser['userID'] == $_SESSION['user']['userID']) {
            $data['error'] = "Error: No puedes eliminarte a ti mismo";
        } else {
            $data['deletedUser'] = $deletedUser['username'];
            $userModel->deleteUserById($id);
        }

        $data['users'] = $userModel->getAllUsers();

        $this->view->showViews(array('templates/header.view.php', 'users.view.php', 'templates/footer.view.php'), $data);
    }

    function editUser($id) {
        $userModel = new \Com\Daw2\Models\UserModel();

        $data = [];
        $data['titulo'] = 'Editar usuario';
        $data['seccion'] = 'edit-user';
        $data['user'] = $userModel->getUserById($id);
        $data['id'] = $id;

        if (isset($_POST['submit'])) {
            $input = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            
            if($this->checkEditUserData($input, $data['user'])!=true){
                $data['errores'] = $this->checkEditUserData($input, $data['user']);
            }
        }

        $this->view->showViews(array('templates/header.view.php', 'edit.user.view.php', 'templates/footer.view.php'), $data);
    }

    function checkEditUserData($input, $user) {
        $errors = [];
        $userModel = new \Com\Daw2\Models\UserModel();
        
        // Comprobación de username, solo se aplica el cambio si el username no
        // existe, o es el mismo que el propio usuario que estamos editando
        if (!$userModel->checkUserExists($input['name']) || $input['name'] == $user['username']) {
            if (strlen($input['name']) < 4 || strlen($input['name']) > 16) {
                $errors['name'] = "El nombre de usuario debe tener una longitud de entre 4 y 16 caracteres.";
            } else {
                $editedUser['username'] = $input['name'];
            }
        } else {
            $errors['username'] = "El nombre de usuario ya está registrado";
        }

        // Comprobación de password, si ambas están vacías, se deja la misma, si no,
        // se hacen las comprobaciones, y si es correcto guarda la nueva pass hasheada
        if (empty($input['pass']) && empty($input['pass2'])) {
            $editedUser['pass'] = $user['password'];
        } else if ($this->checkUserPassword($input['pass'], $input['pass2']) !== null) {
            $errors['password'] = $this->checkUserPassword($input['pass'], $input['pass2']);
        } else {
            $editedUser['pass'] = password_hash($input['pass'], PASSWORD_DEFAULT);
        }
        
        // Comprobación de userType, si es 0 o 1 se modifica, si no, se aplica
        // el que ya tenía el usuario previamente.
        if($input['type']==0 || $input['type']==1){
            $editedUser['userType'] = $input['type'];
        }else{
            $editedUser['userType'] = $user['userType'];
        }
        
        // Si no hay errores, se modifica el usuario con los nuevos datos
        if(count($errors)==0){
            $userModel->editUserData($editedUser,$user['userID']);
            return true;
        }
        return $errors;
    }
}
