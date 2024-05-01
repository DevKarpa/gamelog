<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../assets/css/client/profile.style.css" type="text/css">
        <link rel="stylesheet" href="../assets/css/client/main.style.css" type="text/css">
        <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
        <title>Amigos de <?php echo $user['username'] ?></title>
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
            
            <section class="topSection">
                <div class="userInfo">
                    <div class="userImg">
                        <img src="../assets/img/profile/<?php echo $user['userID'] ?>.jpg">
                    </div>
                    <div class="userText">
                        <span><?php echo $user['username'] ?></span>
                        <span>@<?php echo $user['username'] ?></span>
                        <span><?php echo $user['userDesc'] ?></span>
                    </div>
                </div>
                
                <div class="userSubMenu">
                    <ul>
                        <li><a href="/profile/<?php echo $user['userID'] ?>?page=1&order=0&status=4">Perfil</a></li>
                        <li><a href="/profilefriends/<?php echo $user['userID'] ?>">Amigos</a></li>
                        <?php if (isset($_SESSION['user'])) {
                            if ($_SESSION['user']['userID'] == $user['userID']) {?>
                        <li><a href="/settings">Editar&nbsp;Perfil</a></li>
                        <?php } }?>
                    </ul>
                </div>
            </section>
            
            <div class="centerPage">
                <aside>
                    <section class="userCon">
                        <span class="asideTitle">Conexiones</span>
                        <ul>
                            <li><a href="#">Twitter</a></li>
                            <li><a href="#">Steam</a></li>
                            <li><a href="#">Xbox</a></li>
                            <li><a href="#">Playstation</a></li>
                            <li><a href="#">Nintendo</a></li>
                        </ul>
                    </section>
                    <section class="userStats">
                        <span class="asideTitle">Estadísticas</span>
                        <article class="userStatsCont">
                            
                            <a href="/profile/<?php echo $user['userID'] ?>?page=1&order=<?php echo $order ?>&status=3">
                                <div class="userStat">
                                    <span>Completados</span>
                                    <span><?php echo $completedGames ?></span>
                                </div>
                            </a>
                            
                            <a href="/profile/<?php echo $user['userID'] ?>?page=1&order=<?php echo $order ?>&status=2">
                                <div class="userStat">
                                    <span>Jugando</span>
                                    <span><?php echo $playingGames ?></span>
                                </div>
                            </a>
                            
                            <a href="/profile/<?php echo $user['userID'] ?>?page=1&order=<?php echo $order ?>&status=1">
                                <div class="userStat">
                                    <span>Pendientes</span>
                                    <span><?php echo $pendingGames ?></span>
                                </div>
                            </a>
                            
                            <a href="/profile/<?php echo $user['userID'] ?>?page=1&order=<?php echo $order ?>&status=0">
                                <div class="userStat">
                                    <span>Pausados</span>
                                    <span><?php echo $droppedGames ?></span>
                                </div>
                            </a>
                            
                            <a href="/profile/<?php echo $user['userID'] ?>?page=1&order=<?php echo $order ?>&status=4">
                                <div class="userStat">
                                    <span>Total</span>
                                    <span><?php echo count($allgames) ?></span>
                                </div>
                            </a>
                            
                        </article>
                    </section>
                </aside>
                <main>
                    <section class="gameListContainer">
                        <div class="gameListTitle">
                            <span class="glTitle">Amigos</span>
                            <span class="glSub"><?php echo count($friends) ?></span>
                        </div>
                        <div class="friendList">
                            <?php if (count($friends) != 0) { 
                            foreach ($friends as $friend) { ?>
                      
                            <a class="friend" href='/profile/<?php echo $friend['userID'] ?>?page=1&order=0&status=4'>
                                <div class="friendImg">
                                    <img src="../assets/img/profile/<?php echo $friend['userID']?>.jpg">
                                </div>
                                <div class="friendText">
                                    <span><?php echo $friend['username'] ?></span>
                                    <span>@<?php echo $friend['username'] ?></span>
                                </div>
                            </a>
                            
                            <?php }}else{
                                echo "<span class='noGamesAlert'>No tienes amigos :(<span>";
                            } ?>
                        </div>
                    </section>
                </main>
            </div>
                                    <?php
                                    if (isset($pending)) {
                                        if (count($pending) > 0) {
                                            foreach ($pending as $pendiente) {
                                                echo "<a href='/profile/" . $pendiente['userID'] . "?page=1&order=0&status=4'>" . $pendiente['username'] . "</a> <a href='/accept/" . $pendiente['userID'] . "'>Aceptar</a> <a href='/reject/" . $pendiente['userID'] . "'>Rechazar</a>" . "<br>";
                                            }
                                        }
                                    }
                                    
                                    ?>
        <?PHP
            // AÑADIR AMIGO
            if(isset($_SESSION['user'])){
                if ($_SESSION['user']['userID'] != $user['userID']) {
                    if (!in_array($user['userID'], $_SESSION['friends'])) {
                        ?> <a href="/addfriend/<?php echo $user['userID'] ?>"> + Añadir amigos</a><br> <?php
                    }
                } 
            }
        ?>
                                        

                                    
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
    </body>
</html>