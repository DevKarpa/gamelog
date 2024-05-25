<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../assets/css/client/profile.style.css" type="text/css">
        <link rel="stylesheet" href="../assets/css/client/main.style.css" type="text/css">
        <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
        <title><?php echo $user['username'] ?></title>
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
                        <li><a href="/profile/<?php echo $user['userID'] ?>?page=1&order=0&status=4">Perfil</a></li>
                        <li><a href="/profilefriends/<?php echo $user['userID'] ?>">Siguiendo</a></li>
                        <li><a href="/profilefriendsc/<?php echo $user['userID'] ?>">Seguidores</a></li>
                        <?php if (isset($_SESSION['user'])) {
                            if ($_SESSION['user']['userID'] == $user['userID']) {?>
                        <li><a href="/settings">Editar&nbsp;Perfil</a></li>
                        <?php } }?>
                    </ul>
                    <?PHP
                    // AÑADIR AMIGO
                    if(isset($_SESSION['user'])){
                        if ($_SESSION['user']['userID'] != $user['userID']) {
                            if (!in_array($user['userID'], $_SESSION['friends'])) {
                                ?> <div class="followCont"> <a class="followBtn" href="/addfriend/<?php echo $user['userID'] ?>">Seguir</a> </div><?php
                            }else{
                                ?> <div class="followCont"> <a class="followBtn unfollow" href="/unfollow/<?php echo $user['userID'] ?>">Dejar de seguir</a> </div><?php
                            }
                        } 
                    }
                    ?>
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
                                <div class="userStat<?php echo ($status==3) ? " selectedStat" : "" ?>">
                                    <span>Completados</span>
                                    <span><?php echo $completedGames ?></span>
                                </div>
                            </a>
                            
                            <a href="/profile/<?php echo $user['userID'] ?>?page=1&order=<?php echo $order ?>&status=2">
                                <div class="userStat<?php echo ($status==2) ? " selectedStat" : "" ?>">
                                    <span>Jugando</span>
                                    <span><?php echo $playingGames ?></span>
                                </div>
                            </a>
                            
                            <a href="/profile/<?php echo $user['userID'] ?>?page=1&order=<?php echo $order ?>&status=1">
                                <div class="userStat<?php echo ($status==1) ? " selectedStat" : "" ?>">
                                    <span>Pendientes</span>
                                    <span><?php echo $pendingGames ?></span>
                                </div>
                            </a>
                            
                            <a href="/profile/<?php echo $user['userID'] ?>?page=1&order=<?php echo $order ?>&status=0">
                                <div class="userStat<?php echo ($status==0) ? " selectedStat" : "" ?>">
                                    <span>Pausados</span>
                                    <span><?php echo $droppedGames ?></span>
                                </div>
                            </a>
                            
                            <a href="/profile/<?php echo $user['userID'] ?>?page=1&order=<?php echo $order ?>&status=4">
                                <div class="userStat<?php echo ($status==4) ? " selectedStat" : "" ?>">
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
                            <span class="glTitle">Juegos</span>
                            <span class="glSub"><?php echo count($allgames) ?></span>
                        </div>
                        <div class="gameListOrder">
                            <ul>
                                <li><a href="/profile/<?php echo $user['userID'] ?>?page=<?php echo $page ?>&order=0&status=<?php echo $status ?>">Nombre</a></li>
                                <li><a href="/profile/<?php echo $user['userID'] ?>?page=<?php echo $page ?>&order=2&status=<?php echo $status ?>">Fecha Inicio</a></li>
                                <li><a href="/profile/<?php echo $user['userID'] ?>?page=<?php echo $page ?>&order=3&status=<?php echo $status ?>">Fecha Fin</a></li>
                            </ul>
                        </div>
                        <div class="gameList">
                            <?php if (count($games) != 0) { 
                            foreach ($games as $game) { ?>
                            <div class='game'>
                                <div class='gameContentLeft'>
                                        <div class='gameImg'>
                                            <?php echo "<img src='../assets/img/games/" . $game['gameID'] . ".png'>" ?>
                                        </div>
                                        <div class='gameText'>
                                            <?php
                                                if(isset($game['nota'])){
                                                    $class = ($game['nota']<=100 && $game['nota']>=81) ? "gnExcelent" : (($game['nota']<=80 && $game['nota']>=61) ? "gnGood" : (($game['nota']<=60 && $game['nota']>=40) ? "gnMixed" : (($game['nota']<=39 && $game['nota']>=0) ? "gnBad" : "")));
                                                }
                                            ?>
                                            <?php echo "<span class='gameTitle'>" . $game['gameTitle'] . (isset($game['nota']) ? "<span class='gameNote " . $class . "'>". $game['nota'] . "</span>" : '') . "</span>" ?>
                                            <div class="gamePlat">
                                                <?php echo "<span>" . $game['platformName'] . "</span>" ?>
                                            </div>
                                            <div class="gameTime">
                                                <?php echo "<span>" . $game['fechaInicio'] . "</span>" ?>
                                                <?php echo "<span>" . $game['fechaFin'] . "</span>" ?>
                                            </div>
                                            
                                        </div>
                                </div>
                                <div class='gameContentRight'>
                                    <?php echo "<span class='gameStatus'>" . $game['statusName'] . "</span>" ?>
                                    <div class='gameButtons'>
                                        <?php
                                            if(isset($_SESSION['user'])){
                                                if ($_SESSION['user']['userID'] == $user['userID']) {
                                                    echo "<a href='/edit/" . $game['gameID'] . "'><i class='fas fa-pen-square'></i></a>";
                                                    echo "<a href='/delete/" . $game['gameID'] . "'><i class='fas fa-trash'></i></a>";
                                                }
                                            }
                                        ?>
                                    </div>
                                </div>     
                            </div>
                            <?php }}else{
                                echo "<span class='noGamesAlert'>No hay juegos<span>";
                            } ?>
                            <div class="paging">
                                <?php if(isset($page)){ ?>
                                    <div class="pageBtn">
                                        <a class="pagingElement" href="/profile/<?php echo $user['userID'] ?>?page=1&order=<?php echo isset($order) ? $order : 0 ?>&status=<?php echo isset($status) ? $status : 4 ?>"><<</a>
                                        <a class="pagingElement" href="/profile/<?php echo $user['userID'] ?>?page=<?php echo $page - 1 < 1 ? 1 : $page - 1 ?>&order=<?php echo isset($order) ? $order : 0 ?>&status=<?php echo isset($status) ? $status : 4 ?>"><</a>
                                        <span class="pageNumber">Página <?php echo $_GET["page"] ?></span>
                                        <a class="pagingElement" href="/profile/<?php echo $user['userID'] ?>?page=<?php echo $maxpage < $page + 1 ? $page : $page + 1 ?>&order=<?php echo isset($order) ? $order : 0 ?>&status=<?php echo isset($status) ? $status : 4 ?>">></a>
                                        <a class="pagingElement" href="/profile/<?php echo $user['userID'] ?>?page=<?php echo $maxpage?>&order=<?php echo isset($order) ? $order : 0 ?>&status=<?php echo isset($status) ? $status : 4 ?>">>></a>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </section>
                </main>
            </div>
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