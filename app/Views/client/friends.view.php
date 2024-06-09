<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../assets/css/client/profile.style.css" type="text/css">
        <link rel="stylesheet" href="../assets/css/client/main.style.css" type="text/css">
        <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
        <link rel="icon" type="image/x-icon" href="../assets/img/favicon.png">

        <title>Gamelog | Siguiendo</title>
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
            
            <section class="topSection">
                <div class="userInfo">
                    <div class="userImg">
                        <img src="../assets/img/profile/<?php echo $user['userID'] ?>.jpg">
                    </div>
                    <div class="userText">
                        <span><?php echo ($user['userDisplayName']==null) ? $user['username'] : $user['userDisplayName'] ?></span>
                        <span>@<?php echo $user['username'] ?></span>
                        <span><?php echo $user['userDesc'] ?></span>
                    </div>
                </div>
                
                <div class="userSubMenu">
                    <ul>
                        <li><a href="/profile/<?php echo $user['userID'] ?>?page=1&order=0&status=4">Juegos</a></li>
                        <li><a href="/profilefriends/<?php echo $user['userID'] ?>">Siguiendo</a></li>
                        <li><a href="/profilefriendsc/<?php echo $user['userID'] ?>">Seguidores</a></li>
                        <?php if (isset($_SESSION['user'])) {
                            if ($_SESSION['user']['userID'] == $user['userID']) {?>
                        <li><a href="/settings">Editar&nbsp;Perfil</a></li>
                        <?php } }?>
                    </ul>
                    
                    <div class="followCont"> <a class="followBtn searchBtn" href="/searchusers">Buscar Usuarios</a> </div>
                </div>
            </section>
            
            <div class="centerPage">
                <aside>
                    <section class="userCon">
                        <span class="asideTitle">Conexiones</span>
                        <ul class="conItems">
                            <?php
                            $count = 0;
                            foreach ($conections as $key => $value) {

                                if($value!=NULL){
                                    echo "<li><i class='fab fa-" . $key . "'></i> $value</li>";
                                    $count++;
                                }
                            }
                            if($count==0){
                                echo "<li>Sin conexiones</li>";
                            }

                            ?>
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
                            <span class="glTitle"><?php echo $title ?></span>
                            <span class="glSub"><?php echo count($friends) ?></span>
                        </div>
                        <div class="friendList">
                            
                            <?php if (count($friends) != 0) { 
                            foreach ($friends as $friend) { ?>

                                <div class='userDiv'>
                                    <div class='userLeft'>
                                        <div class='userImgd'>
                                        <a href='/profile/<?php echo $friend['userID']?>?page=1&order=0&status=4'>
                                            <img src='../assets/img/profile/<?php echo $friend['userID']?>.jpg'>
                                        </a>
                                        </div>
                                        <div class='userText'>
                                            <span><a href='/profile/<?php echo $friend['userID']?>?page=1&order=0&status=4'><?php echo ($friend['userDisplayName']==null) ? $friend['username'] : $friend['userDisplayName'] ?></a></span>
                                            <span><a href='/profile/<?php echo $friend['userID']?>?page=1&order=0&status=4'>@<?php echo $friend['username']?></a></span>
                                        </div>
                                    </div>
                                </div>
                            
                            <?php }}else{
                                echo "<span class='noGamesAlert'>No existen resultados :(<span>";
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
                            
        </div>
        <footer>
            <div class="footLeft">
                <span>GameLog</span>
                <span>GameLog no está asociada con ninguna de las compañías dueñas de los juegos mostrados.</span>
                <span>©️ GameLog 2024</span>
            </div>
            <div class="footRight">
                <div class="socialMedia">
                    <a href="https://discord.com/" title="Servidor de Discord"><i class="footImg fab fa-discord"></i></a>
                    <a href="https://store.steampowered.com/?l=spanish" title="Grupo de Steam"><i class="footImg fab fa-steam"></i></i></a>
                    <a href="https://twitter.com/" title="Cuenta de Twitter"><i class="footImg fab fa-twitter"></i></i></a>
                    <a href="https://www.facebook.com/" title="Grupo de Facebook"><i class="footImg fab fa-facebook"></i></i></a>
                </div>
                <div class="footLinks">
                    <a href="/help#1">Terminos de Servicio</a>
                    <a href="/help#2">Política de Privacidad</a>
                    <a href="/help#3">FAQ</a>
                </div>
            </div>
        </footer>
        <script src="https://unpkg.com/@popperjs/core@2"></script>
        <script src="https://unpkg.com/tippy.js@6"></script>
        <?php include("plugins/dropdownmenu/drop.php"); ?>
    </body>
</html>