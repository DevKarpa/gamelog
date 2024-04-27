<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="assets/css/client/main.style.css">
        <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
        <title>EDITAR PERFIL</title>
    </head>
    <body>
        <div style="color:red">
            <?php
                if (isset($errors)) {
                    foreach ($errors as $error) {
                        echo $error . "<br>";
                    }
                }
            ?>
        </div>
        <a href="/logout">Logout</a><br>
        <a href="/profile/<?php echo $_SESSION['user']['userID'] ?>?page=1&order=0&status=4">Back</a>
        <h1>Cosas de editar perfil</h1>
        <h2>Editando perfil de <?php echo $user['username'] ?></h2>
        <form action="/settings" method="post" enctype="multipart/form-data">
            <label>Nombre de usuario: </label>
            <input type="text" name="usernamec" value="<?php echo $user['username'] ?>">
            <label>Nueva contraseña: &nbsp;</label>
            <input type="password" name="passwordc1" placeholder="Contraseña">
            <input type="password" name="passwordc2" placeholder="Repetir contraseña"><br>
            <input type="submit" name="submit" id="submit" value="Enviar">
        </form>
        
        <footer>
            <div class="footLeft">
                <span>GameLog</span>
                <span>GameLog no está asociada con ninguna de las compañías dueñas de los juegos mostrados.</span>
                <span>©️ GameLog 2024</span>
            </div>
            <div class="footRight">
                <div class="socialMedia">
                    <a href="#"><i class="footImg fab fa-discord"></i></a>
                    <a href="#"><i class="footImg fab fa-steam"></i></i></a>
                    <a href="#"><i class="footImg fab fa-twitter"></i></i></a>
                    <a href="#"><i class="footImg fab fa-facebook"></i></i></a>
                </div>
                <div class="footLinks">
                    <a href="#">Terminos de Servicio</a>
                    <a href="#">Política de Privacidad</a>
                    <a href="#">FAQ</a>

                </div>
            </div>
        </footer>
    </body>
</html>