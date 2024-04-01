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
        <?php
            foreach ($games as $game) {
                echo $game['gameTitle'] . " ";
                echo "<a href='/add/". $game['gameID'] ."'>+</a>";
                echo "<br>";
            }
        ?>
    </body>
</html>