<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $user['username'] ?></title>
    </head>
    <body>
        <a href="/logout">Logout</a><br>
        <a href="/">Back</a>
        <h1>PERFIL DE <?php echo $user['username'] ?></h1>
        <?php
        if ($_SESSION['user']['userID'] == $user['userID']) {
            ?>
            <h2>IF el perfil es mio</h2>
            <h3><a href="/settings">Editar Perfil</a></h3>
            <a href="/search">Añadir juego</a><br>
            <?php
        }
        foreach ($games as $game) {
            echo $game['gameTitle'] . " " . $game['developers'] . " " . $game['platformName'] . " " . $game['fechaInicio'] . " " . $game['fechaFin'] . " " . $game['statusName'];
            if($_SESSION['user']['userID'] == $user['userID']){
                echo "<a href='/edit/". $game['gameID'] ."'> EDIT</a>"; ?>&nbsp;&nbsp;<?php
                echo "<a href='/delete/". $game['gameID'] ."'> DELETE</a><br>";
            }else{
                echo "<br>";
            }
        }
        ?>


    </body>
</html>