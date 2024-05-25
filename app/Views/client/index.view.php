<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>GameLog</title>
        <link rel="stylesheet" href="assets/css/client/index.style.css">
        <link rel="stylesheet" href="assets/css/client/main.style.css">   
        <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    </head>
    <body>
        <div class="content">
            <header>
                <nav>
                    <ul>
                        <?php if (isset($_SESSION['user'])) { ?>

                        <?php } else { ?>
                            <li><a href="/register">Registrarse</a></li> <?php } ?>
                        <li><a href="/search">Buscar Juegos</a></li>
                        <li><a href="/help">Ayuda</a></li>
                        <?php if (isset($_SESSION['user'])) { ?>
                            <li><a href="#" id="dropdown" class="glUserImg"><img src="../assets/img/profile/<?php echo $_SESSION['user']['userID'] ?>.jpg"></a></li>

                        <?php } ?>
                    </ul>
                </nav>
                <div class="headerTxtImg"></div>
                <div class="headerTxtImg2"></div>
                
                    <div class="headerTxt">
                        <h1 id="title">GameLog</h1>
                        <h2>Lleva el registro de tus juegos</h2>
                        <div class="headerAction">
                            <a id="headerButton" href="<?php echo isset($_SESSION['user']) ? '/profile/' . $_SESSION['user']['userID'] . '?page=1&order=0&status=4' : '/register' ?> "><?php echo isset($_SESSION['user']) ? 'Mi Perfil' : 'Crear una cuenta' ?></a>
                            <span><?php echo isset($_SESSION['user']) ? 'Muestra el listado de tus juegos en tu perfil' : 'O <a href="/login">inicia sesión</a> si ya tienes cuenta' ?></span>
                        </div>
                    </div>
                
            </header>
            <main>
                
                <section class="stats">
                    <div class="statBlock">
                        <i class="statIcon fas fa-user"></i>
                        <div class="statText">
                            <span class="statTitle">Usuarios</span>
                            <span class="statNum">212K</span>
                        </div>
                    </div>
                    <div class="statBlock">
                        <i class="statIcon fas fa-gamepad"></i>
                        <div class="statText">
                            <span class="statTitle">Juegos</span>
                            <span class="statNum">39K</span>
                        </div>
                    </div>
                    <div class="statBlock">
                        <i class="statIcon fas fa-bookmark"></i>
                        <div class="statText">
                            <span class="statTitle">Registros</span>
                            <span class="statNum">992K</span>
                        </div>
                    </div>
                </section>

                <section class="articles">
                    <article>
                        <p id="articleTitle">¿Quieres organizar un poco tu biblioteca?</p>
                        <p id="articleText">No te preocupes, con GameLog puedes empezar a llevar de forma clara la cuenta de los títulos que has completado, estás jugando, los que tengas pendientes o incluso los que has dejado abandonados. <span id="articleLt">A los juegos no les gusta que los abandones =(</span></p>
                    </article>
                </section>

                <section class="infoblocks">
                    <div class="infoblock">
                        <i class="infoIcon fas fa-plus-circle"></i>
                        <span class="infoTitle">Tu colección</span>
                        <span class="infoText">Lleva un registro de los juegos que completas</span>
                    </div>
                    <div class="infoblock">
                        <i class="infoIcon fas fa-user"></i>
                        <span class="infoTitle">Añade amigos</span>
                        <span class="infoText">Sigue a tus amigos y compara su registro de juegos con el tuyo</span>
                    </div>
                    <div class="infoblock">
                        <i class="infoIcon fas fa-comment"></i>
                        <span class="infoTitle">Comenta</span>
                        <span class="infoText">Deja comentarios en tus  registros y expresa lo que quieras sobre ese juego.</span>
                    </div>
                </section>

                <section class="popularGamesSection">
                    <p>Juegos Populares</p>
                    <div class="popularGamesBlock">
                        <div class="popularGameItem"><span>Forza Horizon 4</span><img src="assets/img/games/40.png"></div>
                        <div class="popularGameItem"><span>Grand Theft Auto V</span><img src="assets/img/games/100.png"></div>
                        <div class="popularGameItem"><span>Castle Crashers</span><img src="assets/img/games/120.png"></div>
                        <div class="popularGameItem"><span>Left 4 Dead</span><img src="assets/img/games/33.png"></div>
                        <div class="popularGameItem"><span>Spore</span><img src="assets/img/games/9.png"></div>
                        <div class="popularGameItem"><span>Sonic Origins</span><img src="assets/img/games/78.png"></div>
                    </div>
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
                    <a href="/help">Terminos de Servicio</a>
                    <a href="/help">Política de Privacidad</a>
                    <a href="/help">FAQ</a>

                </div>
            </div>
        </footer>
        <script src="https://unpkg.com/@popperjs/core@2"></script>
        <script src="https://unpkg.com/tippy.js@6"></script>
        <script>
            tippy("#dropdown", {
                content: '<ul class="drop"><li><a href="/profile/<?php echo $_SESSION["user"]["userID"] ?>?page=1&order=0&status=4">Mi perfil</a></li><li><a href="/logout">Cerrar sesión</a></li></ul>',
                allowHTML: true,
                trigger: 'click',
                interactive: true,
                placement: 'bottom'
            });
        </script>
    </body>
</html>