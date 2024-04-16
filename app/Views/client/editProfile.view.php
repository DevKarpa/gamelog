<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    </body>
</html>