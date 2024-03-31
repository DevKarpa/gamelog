<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>EDITAR PERFIL</title>
    </head>
    <body>
        <a href="/logout">Logout</a><br>
        <a href="/profile/<?php echo $_SESSION['user']['userID']?>">Back</a>
        <h1>Cosas de editar perfil</h1>
        <h2>Editando perfil de <?php echo $user['username'] ?></h2>
    </body>
</html>