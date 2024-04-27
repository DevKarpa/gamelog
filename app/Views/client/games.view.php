<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./assets/css/client/games.style.css"  type="text/css">
        <link rel="stylesheet" href="./assets/css/client/main.style.css"  type="text/css">
        <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
        <title>Buscar juegos</title>
    </head>
    <body>
        <div class="content">
            <header>
                <h1 class="title"><a href="/">GameLog</a></h1>
                <nav>
                    <ul>
                        <?php if (isset($_SESSION['user'])) { ?>
                            <li><a href="/profile/<?php echo $_SESSION['user']['userID'] ?>?page=1&order=0&status=4">Mi perfil</a></li>
                        <?php } else { ?>
                            <li><a href="/register">Registrarse</a></li> <?php } ?>
                        <li><a href="/search">Buscar Juegos</a></li>
                        <li><a href="/help">Ayuda</a></li>
                        <?php if (isset($_SESSION['user'])) { ?>
                            <li><a href="/logout">Cerrar sesión</a></li>
                        <?php } ?>
                    </ul>
                </nav>
            </header>
            <main>
                <section class="gameSearch">
                    <h2>Busca juegos que añadir a tu perfil</h2>
                    <form>
                        <input type="text" id="gametxt" onkeyup="showGame(this.value)" placeholder="Título del juego...">
                        <select name="platform" id="platform" onclick="showGame(document.getElementById('gametxt').value)">
                            <option value="0">Todas</option>
                            <?php
                            foreach ($platforms as $plat) {
                                echo "<option value='" . $plat['platformID'] . "'>" . $plat['platformName'] . "</option>";
                            }
                            ?>
                        </select>
                    </form>
                </section>
                <section class="gameShow">
                    <div id="gamelist"></div>
                </section>
            </main>
        </div>
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