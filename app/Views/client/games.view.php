<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>LISTA DE JUEGOS</title>
    </head>
    <body>
        <?php
        if (isset($_SESSION['user'])) {
            ?> <a href="/logout">Logout</a> 
            <h2><a href="/profile/<?php echo $_SESSION['user']['userID'] ?>?page=1&order=0&status=4">Mi perfil</a></h2>
            <?php
        } else {
            ?> <a href="/login">Iniciar Sesión</a> <?php
            ?> <a href="/register">Registrarse</a> <?php
        }
        ?><br>
        <a href="/">Back</a>

        <h1>BARRA DE BUSQUEDA GRANDE</h1>
        <form>
            Juego: <input type="text" id="gametxt" onkeyup="showGame(this.value)">
            <select name="platform" id="platform" onclick="showGame(document.getElementById('gametxt').value)">
                <option value="0">Todas</option>
                <?php
                foreach ($platforms as $plat) {
                    echo "<option value='" . $plat['platformID'] . "'>" . $plat['platformName'] . "</option>";
                }
                ?>
            </select>
        </form>
        <div id="gamelist"></div>
        <script>
            gamelist = document.getElementById('gamelist');
            platform = document.getElementById('platform');

            function showGame(txt) {
                
                if (txt.length != 0) {

                    var xmlhttp = new XMLHttpRequest();

                    xmlhttp.onreadystatechange = function () {
                        if (this.readyState == 4 && this.status == 200) {
                            gamelist.innerHTML = this.responseText;
                        }
                    }

                    // La dirección cambia si la web está hosteada en remoto
                    xmlhttp.open("GET", "http://gamelog.localhost:8080/async/" + txt.toLowerCase() + "/" + platform.value, true);
                    xmlhttp.send();

                } else {
                    gamelist.innerHTML = "";
                }

            }
        </script>
    </body>
</html>