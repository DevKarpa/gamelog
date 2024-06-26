<?php

declare(strict_types=1);

namespace Com\Gamelog\Controllers;

class UserController extends \Com\Gamelog\Core\BaseController {

    // Logea al usuario si coinciden las credenciales y guarda sus datos
    // en sesión, al igual que a su lista de amigos.
    function loginUser(): void {
        $userModel = new \Com\Gamelog\Models\UserModel();
        $user = null;
        $data = [];

        $loginData = $_POST;
        if (isset($loginData['username']) && isset($loginData['pass'])) {
            if ($userModel->loginUser($loginData['username'], $loginData['pass'])) {
                $user = $userModel->loginUser($loginData['username'], $loginData['pass']);
                $_SESSION['user'] = $user;
                $_SESSION['friends'] = $userModel->getFriendsIDFromUserID($user['userID']);
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

    // Registra al usuario si las credenciales son válidas y ya no están
    // siendo utilizadas, y guarda en sesión los datos.
    function registerUser(): void {
        $userModel = new \Com\Gamelog\Models\UserModel();
        $userCon = new \Com\Gamelog\Models\UserConectionsModel();
        $data = [];
        $data['register'] = true;

        if (isset($_POST['submit'])) {
            if (isset($_POST['username']) && isset($_POST['pass']) && isset($_POST['pass2'])) {
                if (count($this->checkRegisterData($_POST)) == 0) {
                    echo "todo bien";
                    $_SESSION['user'] = $userModel->registerUser($_POST);
                    $_SESSION['friends'] = $userModel->getFriendsIDFromUserID($_SESSION['user']['userID']);
                    $userCon->createNewRegister($_SESSION['user']['userID']);
                    copy("assets/img/profile/2.jpg", "assets/img/profile/" . $_SESSION['user']['userID'] . ".jpg");
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

    // Cierra el login el usuario destruyendo la sesisón
    function logout() {
        session_destroy();
        header("location: /");
    }

    // Guarda todos los usuarios para llevarlos a la vista
    function showAllUsers() {
        $userModel = new \Com\Gamelog\Models\UserModel();
        $data = [];
        $data['titulo'] = 'Lista de usuarios';
        $data['seccion'] = 'user-list';
        $data['users'] = $userModel->getAllUsers();

        $this->view->showViews(array('templates/header.view.php', 'users.view.php', 'templates/footer.view.php'), $data);
    }

    // Comprueba que los datos introducidos en el formulario de registro son correctos
    function checkRegisterData($data): array {
        $errors = [];
        $userModel = new \Com\Gamelog\Models\UserModel();

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

    // Comprueba que las contraseñas sean válidas y cumplan con los requisitos
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

    // Elimina a un usuario desde la vista de admin, no te puedes borrar a ti
    // mismo.
    function deleteUser($id) {
        $userModel = new \Com\Gamelog\Models\UserModel();
        $userCon = new \Com\Gamelog\Models\UserConectionsModel();
        $deletedUser = $userModel->getUserById($id);

        $data = [];
        $data['titulo'] = 'Lista de usuarios';
        $data['seccion'] = 'user-list';

        if ($deletedUser['userID'] == $_SESSION['user']['userID']) {
            $data['error'] = "Error: No puedes eliminarte a ti mismo";
        } else {
            $data['deletedUser'] = $deletedUser['username'];
            $userModel->deleteUserById($id);
            $userCon->deleteRegister($id);
        }


        $data['users'] = $userModel->getAllUsers();

        $this->view->showViews(array('templates/header.view.php', 'users.view.php', 'templates/footer.view.php'), $data);
    }

    // Carga la vista para editar a un usuario
    function editUser($id) {
        $userModel = new \Com\Gamelog\Models\UserModel();

        $data = [];
        $data['titulo'] = 'Editar usuario';
        $data['seccion'] = 'edit-user';
        $data['user'] = $userModel->getUserById($id);
        $data['id'] = $id;

        if (isset($_POST['submit'])) {
            $input = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);

            $data['errores'] = $this->checkEditUserData($input, $data['user']);
        }

        $this->view->showViews(array('templates/header.view.php', 'edit.user.view.php', 'templates/footer.view.php'), $data);
    }

    // Comprueba que los datos introducidos para editar un usuario sean correctos
    function checkEditUserData($input, $user) {
        $errors = [];
        $userModel = new \Com\Gamelog\Models\UserModel();

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
        if ($input['type'] == 0 || $input['type'] == 1) {
            $editedUser['userType'] = $input['type'];
        } else {
            $editedUser['userType'] = $user['userType'];
        }

        // Si no hay errores, se modifica el usuario con los nuevos datos
        if (count($errors) == 0) {
            $userModel->editUserData($editedUser, $user['userID']);
        }
        return $errors;
    }

    // FUNCIONES USADAS PARA LA VISTA DEL USUARIO NO ADMINISTRADOR
    // Muestra el perfil de un usuario, sus juegos, amigos, y con paginación
    // y ordenamiento.
    function showUserProfile($id) {
        $userModel = new \Com\Gamelog\Models\UserModel();
        $userGamesModel = new \Com\Gamelog\Models\UserGamesModel();
        $userCon = new \Com\Gamelog\Models\UserConectionsModel();
        $data = [];
        $data['user'] = $userModel->getUserById($id);
        $data['friends'] = $userModel->getFriendsFromUserID($id);
        $data['allgames'] = $userGamesModel->getGamesByUserID($id);
        $data['completedGames'] = count($userGamesModel->getCompletedGamesByUserID($id));
        $data['playingGames'] = count($userGamesModel->getPlayingGamesByUserID($id));
        $data['pendingGames'] = count($userGamesModel->getPendingGamesByUserID($id));
        $data['droppedGames'] = count($userGamesModel->getDroppedGamesByUserID($id));
        $data['order'] = isset($_GET['order']) ? filter_var($_GET['order'], FILTER_SANITIZE_NUMBER_INT) : 0;
        $data['status'] = isset($_GET['status']) ? filter_var($_GET['status'], FILTER_SANITIZE_NUMBER_INT) : 4;
        $data['maxpage'] = ceil(count($userGamesModel->getGamesByUserIDandStatus($id, $data['status'])) / 10);
        $data['conections'] = $userCon->getAllConectionsFromUserID($id);
        //$data['pending'] = $userModel->checkPendingFriendRequest($id);
        // Si existe page en el get
        if (isset($_GET['page'])) {
            $data['page'] = $_GET['page'];
            $offset = ($data['page'] - 1) * 10;
            // Según el orden se ejecuta una consulta u otra para mostrar los juegos
            switch ($data['order']) {
                case 0:
                    $data['games'] = $userGamesModel->getPagedGamesByUserIDandName($id, $offset, $data['status']);
                    break;
                case 1:
                    $data['games'] = $userGamesModel->getPagedGamesByUserIDandDevs($id, $offset, $data['status']);
                    break;
                case 2:
                    $data['games'] = $userGamesModel->getPagedGamesByUserIDandInicio($id, $offset, $data['status']);
                    break;
                case 3:
                    $data['games'] = $userGamesModel->getPagedGamesByUserIDandFin($id, $offset, $data['status']);
                    break;
                default:
                    $data['games'] = $userGamesModel->getPagedGamesByUserID($offset, $id);
                    break;
            }
        } else {
            $data['games'] = $userGamesModel->getGamesByUserID($id);
        }

        $this->view->showViews(array('client/profile.view.php'), $data);
    }

    function showUserProfileFriends($id) {
        $userModel = new \Com\Gamelog\Models\UserModel();
        $userGamesModel = new \Com\Gamelog\Models\UserGamesModel();
        $userCon = new \Com\Gamelog\Models\UserConectionsModel();
        $data = [];
        $data['title'] = "Siguiendo";
        $data['user'] = $userModel->getUserById($id);
        $data['friends'] = $userModel->getFriendsFromUserID($id);
        $data['allgames'] = $userGamesModel->getGamesByUserID($id);
        $data['completedGames'] = count($userGamesModel->getCompletedGamesByUserID($id));
        $data['playingGames'] = count($userGamesModel->getPlayingGamesByUserID($id));
        $data['pendingGames'] = count($userGamesModel->getPendingGamesByUserID($id));
        $data['droppedGames'] = count($userGamesModel->getDroppedGamesByUserID($id));
        $data['order'] = isset($_GET['order']) ? filter_var($_GET['order'], FILTER_SANITIZE_NUMBER_INT) : 0;
        $data['status'] = isset($_GET['status']) ? filter_var($_GET['status'], FILTER_SANITIZE_NUMBER_INT) : 4;
        $data['maxpage'] = ceil(count($userGamesModel->getGamesByUserIDandStatus($id, $data['status'])) / 5);
        $data['conections'] = $userCon->getAllConectionsFromUserID($id);

        $this->view->showViews(array('client/friends.view.php'), $data);
    }

    function showUserProfileFriendsc($id) {
        $userModel = new \Com\Gamelog\Models\UserModel();
        $userGamesModel = new \Com\Gamelog\Models\UserGamesModel();
        $userCon = new \Com\Gamelog\Models\UserConectionsModel();
        $data = [];
        $data['title'] = "Seguidores";
        $data['user'] = $userModel->getUserById($id);
        $data['friends'] = $userModel->getFriendscFromUserID($id);
        $data['allgames'] = $userGamesModel->getGamesByUserID($id);
        $data['completedGames'] = count($userGamesModel->getCompletedGamesByUserID($id));
        $data['playingGames'] = count($userGamesModel->getPlayingGamesByUserID($id));
        $data['pendingGames'] = count($userGamesModel->getPendingGamesByUserID($id));
        $data['droppedGames'] = count($userGamesModel->getDroppedGamesByUserID($id));
        $data['order'] = isset($_GET['order']) ? filter_var($_GET['order'], FILTER_SANITIZE_NUMBER_INT) : 0;
        $data['status'] = isset($_GET['status']) ? filter_var($_GET['status'], FILTER_SANITIZE_NUMBER_INT) : 4;
        $data['maxpage'] = ceil(count($userGamesModel->getGamesByUserIDandStatus($id, $data['status'])) / 5);
        $data['conections'] = $userCon->getAllConectionsFromUserID($id);

        $this->view->showViews(array('client/friends.view.php'), $data);
    }

    // Carga la vista para editar tu usuario, comprueba si los datos introducidos
    // están correctos.
    function editCurrentUser() {
        $userModel = new \Com\Gamelog\Models\UserModel();
        $userCon = new \Com\Gamelog\Models\UserConectionsModel();
        $data = [];
        $data['user'] = $_SESSION['user'];
        $data['conections'] = $userCon->getAllConectionsFromUserID($data['user']['userID']);

        if (isset($_POST['usernamec'])) {
            $username = filter_var($_POST['usernamec'], FILTER_SANITIZE_SPECIAL_CHARS);

            if (count($this->checkUsername($data['user']['userID'], $username)) == 0) {
                $userModel->changeUsername($data['user']['userID'], $username);
                // Cambia en tiempo real el valor de sesión de username para poder ver el cambio
                // sin tener que cerrar la sesión
                $_SESSION['user']['username'] = $username;
                $data['user'] = $_SESSION['user'];
            } else {
                $data['errors'] = $this->checkUsername($data['user']['userID'], $username);
            }
        }

        if (!empty($_POST['passwordc1']) && !empty($_POST['passwordc2'])) {
            if ($this->checkUserPassword($_POST['passwordc1'], $_POST['passwordc2']) == null) {
                $userModel->changePassword($data['user']['userID'], $_POST['passwordc1']);
            } else {
                $data['errors'] = $this->checkUserPassword($_POST['passwordc1'], $_POST['passwordc2']);
            }
        }

        if (isset($_POST['displayNamec'])) {
            $displayName = filter_var($_POST['displayNamec'], FILTER_SANITIZE_SPECIAL_CHARS);
            $userModel->changeDisplayName($data['user']['userID'], $displayName);
            $_SESSION['user']['userDisplayName'] = $displayName;
            $data['user'] = $_SESSION['user'];
        }

        if (isset($_POST['submit'])) {
            $con = ["twitter" => $_POST['twitter'], "steam" => $_POST['steam'], "xbox" => $_POST['xbox'], "playstation" => $_POST['playstation'], "nintendo" => $_POST['nintendo']];

            $userCon->updateRegisterFromUserID($data['user']['userID'], $con);

            //Recarga las conexiones
            $data['conections'] = $userCon->getAllConectionsFromUserID($data['user']['userID']);
        }

        if (!empty($_POST['descc'])) {
            $desc = filter_var($_POST['descc'], FILTER_SANITIZE_SPECIAL_CHARS);
            $userModel->updateDescription($data['user']['userID'], $desc);
            $_SESSION['user']['userDesc'] = $desc;
            $data['user'] = $_SESSION['user'];
        }

        if(isset($_FILES['img'])) {
            if ($_FILES['img']['name'] != "") {
                if ($this->checkGameImage($_FILES)) {
                    // Llamada a la función que guarda la imagen
                    $userModel->updateImage($_FILES, $data['user']['userID']);
                }
            }
        }

        $this->view->showViews(array('client/editProfile.view.php'), $data);
    }

    // Comprueba que el archivo subido se trata de una imagen
    function checkGameImage($img) {
        $upload = true;

        $check = getimagesize($img["img"]["tmp_name"]);
        if ($check === false) {
            $upload = false;
        }

        return $upload;
    }

    // Comprueba que un nombre de usuario sea válido
    function checkUsername($id, $username) {
        $userModel = new \Com\Gamelog\Models\UserModel();
        $errors = [];

        if (!$userModel->checkUsernameExists($id, $username)) {
            if (strlen($username) < 4 || strlen($username) > 16) {
                $errors['username'] = "El nombre de usuario debe tener una longitud de entre 4 y 16 caracteres.";
            }
        } else {
            $errors['username'] = "Este nombre ya pertenece a otro usuario";
        }

        return $errors;
    }

    // Añade un amigo a tu lista, y carga de vuelta el perfil del usuario logeado.
    function addFriend($id) {
        $userModel = new \Com\Gamelog\Models\UserModel();
        $userModel->addNewFriend($_SESSION['user']['userID'], $id);
        $_SESSION['friends'] = $userModel->getFriendsIDFromUserID($_SESSION['user']['userID']);
        header("location: /profile/" . $id . "?page=1&order=0&status=4");
    }

    function unfollowUser($id) {
        $userModel = new \Com\Gamelog\Models\UserModel();
        $userModel->unfollowUser($_SESSION['user']['userID'], $id);
        $_SESSION['friends'] = $userModel->getFriendsIDFromUserID($_SESSION['user']['userID']);
        header("location: /profile/" . $id . "?page=1&order=0&status=4");
    }

    function searchUsers() {
        $data = [];
        $this->view->showViews(array('client/users.view.php'), $data);
    }

    function asyncSearchUsers($txt) {

        $userModel = new \Com\Gamelog\Models\UserModel();

        $following = $userModel->getFriendsIDFromUserID($_SESSION['user']['userID']);
        $users = $userModel->getAllUsers();

        foreach ($users as $user) {
            if ($user['userID'] != $_SESSION['user']['userID']) {
                if (str_contains(strtolower($user['username']), $txt)) {

                    $displayname = ($user['userDisplayName'] == null) ? $user['username'] : $user['userDisplayName'];
                    $friend = (in_array($user['userID'], $following)) ? "<a class='fbtn unfollowButton' href='/unfollow/" . $user['userID'] . "'>Unfollow</a>" : "<a class='fbtn followButton' href='/addfriend/" . $user['userID'] . "'>Seguir</a>";

                    echo "
                        <div class='userDiv'>

                            <div class='userLeft'>
                                <div class='userImg'>
                                <a href='/profile/" . $user['userID'] . "?page=1&order=0&status=4'>
                                    <img src='assets/img/profile/" . $user['userID'] . ".jpg'>
                                </a>
                                </div>
                                <div class='userText'>
                                    <span><a href='/profile/" . $user['userID'] . "?page=1&order=0&status=4'>" . $displayname . "</a></span>
                                    <span><a href='/profile/" . $user['userID'] . "?page=1&order=0&status=4'>@" . $user['username'] . "</a></span>
                                </div>

                            </div>
                            <div class='userButton'>
                                " . $friend . "
                            </div>

                        </div>";

                }
            }
        }
    }
}
