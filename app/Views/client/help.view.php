<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../assets/css/client/help.style.css">
        <link rel="stylesheet" href="../assets/css/client/main.style.css">
        <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">

        <title>Ayuda</title>
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
                <section>
                    <h3>¿Que es GameLog?</h3>
                    <p>GameLog es una aplicación web para realizar un seguimiento de los videojuegos que están pendientes, así como de los que se están jugando, los que están completados, o por el contrario, los que se abandonaron antes de finalizarlos.</p>
                </section>

                <section>
                    <h3>Términos de servicio</h3>
                    <p>Al utilizar nuestra plataforma, aceptas los siguientes términos y condiciones:</p>
                    <ul>
                        <li>Para acceder a todas las funciones de GameLog, es posible que necesites registrarte y crear una cuenta. Asegúrate de proporcionar información precisa y mantener tu contraseña segura. Eres responsable de todas las actividades realizadas con tu cuenta.</li>
                        <li>aaa</li>
                    </ul>
                </section>

                <section>
                    <h3>Política de Privacidad</h3>
                    <p>Nos comprometemos a proteger tu privacidad y a cumplir con todas las leyes de protección de datos aplicables. Consulta nuestra Política de Privacidad para obtener más información sobre cómo recopilamos, utilizamos y protegemos tus datos personales.</p>
                </section>

                <section>
                    <h3>Uso de imágenes</h3>
                    <p>Las marcas comerciales y los nombres comerciales utilizados en GameLog son propiedad de sus respectivos propietarios y se están utilizando bajo la ley de <a target="_blank" href="https://es.wikipedia.org/wiki/Uso_justo">Fair Use</a></p>
                </section>

                <section>
                    <h3>Preguntas Frecuentes (FAQ)</h3>
                    <p>aa</p>
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