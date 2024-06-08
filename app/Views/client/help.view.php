<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../assets/css/client/help.style.css">
        <link rel="stylesheet" href="../assets/css/client/main.style.css">
        <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
        <link rel="icon" type="image/x-icon" href="../assets/img/favicon.png">

        <title>Gamelog | Ayuda</title>
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
                        <li>No puedes compartir tu cuenta o credenciales de acceso con nadie.</li>
                        <li>No puedes vender, transferir o permitir que otra persona acceda a tu cuenta o a tus credenciales de acceso, ni ofrecerte a hacerlo.</li>
                        <li>Podemos cancelar o suspender tu cuenta en cualquier momento si detectamos actividad sospechosa.</li>
                    </ul>
                </section>

                <section>
                    <h3>Política de Privacidad</h3>
                    <p>Nos comprometemos a proteger tu privacidad y a cumplir con todas las leyes de protección de datos aplicables. Consulta nuestra Política de Privacidad para obtener más información sobre cómo recopilamos, utilizamos y protegemos tus datos personales.</p>
                    <ul>
                        <li>Recopilamos automáticamente cierta información relativa a tu navegación por GameLog, como el dispositivo y navegador que utilizas para hacerlo.</li>
                    </ul>
                </section>

                <section>
                    <h3>Uso de imágenes</h3>
                    <p>Las marcas comerciales y los nombres comerciales utilizados en GameLog son propiedad de sus respectivos propietarios y se están utilizando bajo la ley de <a target="_blank" href="https://es.wikipedia.org/wiki/Uso_justo">Fair Use</a>, además GameLog funciona bajo un uso no comercial.</p>
                </section>

                <section>
                    <h3>Preguntas Frecuentes (FAQ)</h3>
                    <div class="faqitem">
                        <p class="pregunta">1. ¿Qué es GameLog?</p>
                        <p class="respuesta">GameLog es una plataforma web diseñada para ayudarte a organizar y gestionar tu biblioteca de juegos. Puedes registrar los juegos que has jugado, los que estás jugando y los que planeas jugar, así como seguir a otros usuarios.</p>
                    </div>
                    <div class="faqitem">
                        <p class="pregunta">2. ¿Cómo me registro en GameLog?</p>
                        <p class="respuesta">Para registrarte en GameLog, simplemente haz clic en el botón "Registrarse" en la página principal yproporciona la información solicitada.</p>
                    </div>
                    <div class="faqitem">
                        <p class="pregunta">3. ¿Cómo puedo añadir juegos a mi biblioteca?</p>
                        <p class="respuesta">Para añadir juegos a tu biblioteca, inicia sesión en tu cuenta de GameLog, ve a la sección de <a href="/search">buscar juegos</a>, busca el juego que deseas añadir utilizando la barra de búsqueda y haz clic en el botón de añadir (+). Luego, podrás seleccionar el estado del juego (Pausado, Pendiente, Jugando y Completado) y añadir opcionalmente una nota.</p>
                    </div>
                    <div class="faqitem">
                        <p class="pregunta">4. ¿Puedo personalizar mi perfil?</p>
                        <p class="respuesta">Sí, puedes personalizar tu perfil en GameLog. Ve a la sección de tu perfil y haz clic en "Editar perfil" para cambiar tu nombre, tag, añadir una descripción y vincular tus cuentas (como Steam, Xbox o PlayStation).</p>
                    </div>
                    <div class="faqitem">
                        <p class="pregunta">5. ¿Cómo puedo seguir a otros usuarios?</p>
                        <p class="respuesta">Para seguir a otros usuarios en GameLog, visita el perfil del usuario que deseas seguir y haz clic en el botón "Seguir".</p>
                    </div>
                    <div class="faqitem">
                        <p class="pregunta">6. ¿GameLog es gratis?</p>
                        <p class="respuesta">Sí, GameLog es completamente gratuito. Puedes registrarte, crear tu biblioteca de juegos y utilizar todas las funciones de la plataforma sin ningún costo.</p>
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
        <?php include("plugins/dropdownmenu/drop.php"); ?>
    </body>
</html>