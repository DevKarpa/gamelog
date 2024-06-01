<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="assets/css/client/settings.style.css" type="text/css">
        <link rel="stylesheet" href="assets/css/client/main.style.css" type="text/css">
        <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css" type="text/css">
        <title>EDITAR PERFIL</title>
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

                <?php
                    if (isset($errors)) {
                        echo '<div class="errorbox"><div class="erroritems">';
                            foreach ($errors as $error) {
                                echo $error . "<br><br>";
                            }
                        echo '</div></div>';
                    }
                ?>

                <form action="/settings" method="post" enctype="multipart/form-data">

                    <section class="topSection">
                        <div class="userInfo">
                            <div class="userImg">
                                <a><img src="../assets/img/profile/<?php echo $user['userID'] ?>.jpg"></a>
                            </div>
                            <div class="userText">
                                <span id="dn"><input id="upinput" type="text" name="displayNamec" value="<?php echo ($user['userDisplayName'] == null) ? $user['username'] : $user['userDisplayName'] ?>"></span>
                                <span>@<input id="upinput"  type="text" name="usernamec" value="<?php echo $user['username'] ?>"></span>
                                <span><textarea id="upinput" name="descc"><?php echo $user['userDesc'] ?></textarea></span>
                            </div>
                        </div>

                        <div class="userSubMenu">
                            <ul>
                                <li><a href="/profile/<?php echo $user['userID'] ?>?page=1&order=0&status=4">Perfil</a></li>
                                <li><a href="/profilefriends/<?php echo $user['userID'] ?>">Seguidores</a></li>
                                <?php if (isset($_SESSION['user'])) {
                                    if ($_SESSION['user']['userID'] == $user['userID']) {
                                        ?>
                                        <li><a href="/settings">Editar&nbsp;Perfil</a></li>
                                    <?php }
                                } ?>
                            </ul>
                        </div>
                    </section>

                    <section class="passSection">
                        <h2>Contraseña</h2>
                        <div class="passItem">
                            <input type="password" name="passwordc1" placeholder="Contraseña" autocomplete="off">
                            <input type="password" name="passwordc2" placeholder="Repetir contraseña" autocomplete="off">
                        </div>
                    </section>

                    <section class="conSection">
                        <h2>Conexiones</h2>
                        <div class="conItems">
                            <div class="conItem">
                                <label>Twitter</label>
                                <input type="text" name="twitter" value="<?php echo $conections['twitter'] ?>">
                            </div>
                            <div class="conItem">
                                <label>Steam</label>
                                <input type="text" name="steam" value="<?php echo $conections['steam'] ?>">
                            </div>
                            <div class="conItem">
                                <label>Xbox</label>
                                <input type="text" name="xbox" value="<?php echo $conections['xbox'] ?>">
                            </div>
                            <div class="conItem">
                                <label>Playstation</label>
                                <input type="text" name="playstation" value="<?php echo $conections['playstation'] ?>">
                            </div>
                            <div class="conItem">
                                <label>Nintendo SwitchID</label>
                                <input type="text" name="nintendo" value="<?php echo $conections['nintendo'] ?>">
                            </div>
                        </div>

                    </section>

                    <section class="endSection">
                        <input type="submit" name="submit" id="submit" value="Aplicar">
                    </section>


                </form>
                
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