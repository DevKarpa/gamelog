<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./assets/css/client/users.style.css"  type="text/css">
        <link rel="stylesheet" href="./assets/css/client/main.style.css"  type="text/css">
        <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
        <title>Buscar usuarios</title>
    </head>
    <body>
        <div class="content">
            <header>
                <h1 class="title"><a href="/">GameLog</a></h1>
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
            </header>
            <main>
                <section class="gameSearch">
                    <h2>Busca usuarios a los que seguir</h2>
                    <form>
                        <input type="text" id="gametxt" onkeyup="showUsers(this.value)" placeholder="Nombre de usuario..." style="width: 100%">
                    </form>
                </section>
                <section class="gameShow">
                    <div id="userList"></div>
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
        <script src="plugins/jquery/jquery.min.js"></script>
        <script>

            function showUsers(txt) {

                if (txt.length !== 0) {

                    var xmlhttp = new XMLHttpRequest();

                    xmlhttp.onreadystatechange = function () {
                        if (this.readyState === 4 && this.status === 200) {
                            $("#userList").html(this.responseText);
                        }
                    };

                    xmlhttp.open("GET", "/asyncuser/" + txt.toLowerCase(), true);
                    xmlhttp.send();

                } else {
                    $("#userList").html("");
                }

            }
            
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
