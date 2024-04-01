<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $game['gameTitle'] ?></title>
    </head>
    <body>
        <a href="/logout">Logout</a><br>
        <a href="/search">Back</a>
        <h1><?php echo $game['gameTitle'] // /profile/<?php echo $user['userID']   ?></h1>
        <div style="color:red">
            <?php
            if (isset($errors)) {
                foreach ($errors as $error) {
                    echo $error . "<br><br>";
                }
            }
            ?>
        </div>
        <form action="/add/<?php echo $game['gameID'] ?>" method="post" enctype="multipart/form-data">
            > Inicio: <input type="date" name="start"><br>
            > Final: <input type="date" name="end"><br><br>
            Status:
            <select name="status">
                <option value=0>Cancelado</option>
                <option value=1>Pendiente</option>
                <option value=2>En progreso</option>
                <option value=3>Completado</option>
            </select><br><br>
            <input type="submit" name="submit" id="submit" value="Enviar">
            <input type="button" name="reset" id="reset" value="Reset">
        </form>
    </body>
</html>