<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>LISTA DE JUEGOS</title>
    </head>
    <body>
        <a href="/logout">Logout</a><br>
        <a href="/">Back</a>
        <h1>BARRA DE BUSQUEDA GRANDE</h1>
        <?php $userGames;
            foreach ($games as $game) {
                echo $game['gameTitle'] . " ";
                echo "<a href='/". (in_array($game['gameID'], $userGames) ? 'edit' : 'add') ."/". $game['gameID'] ."'>".(in_array($game['gameID'], $userGames) ? 'EDIT' : 'ADD')."</a>";
                echo "<br>";
            }
        ?>
    </body>
</html>