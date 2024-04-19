<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../assets/css/client/main.style.css">
        <title><?php echo $user['username'] ?></title>
    </head>
    <body>
        <a href="/logout">Logout</a><br>
        <a href="/">Back</a>
        <h1>PERFIL DE <?php echo $user['username'] ?></h1>
        <?php
        if ($_SESSION['user']['userID'] == $user['userID']) {
            ?>
            <h2>IF el perfil es mio</h2>
            <h3><a href="/settings">Editar Perfil</a></h3>
            <a href="/search">Añadir juego</a><br><br>
            <?php
                
        }else if(!in_array($user['userID'],$_SESSION['friends'])){
            ?> <a href="/addfriend/<?php echo $user['userID'] ?>">+ Añadir amigos</a><br> <?php
        }
        ?>
        <a href="/profile/<?php echo $user['userID'] ?>?page=<?php echo $page ?>&order=0&status=<?php echo $status ?>">Nombre</a>
        <a href="/profile/<?php echo $user['userID'] ?>?page=<?php echo $page ?>&order=1&status=<?php echo $status ?>">Devs</a>
        <a href="/profile/<?php echo $user['userID'] ?>?page=<?php echo $page ?>&order=2&status=<?php echo $status ?>">Fecha Inicio</a>
        <a href="/profile/<?php echo $user['userID'] ?>?page=<?php echo $page ?>&order=3&status=<?php echo $status ?>">Fecha Fin</a>
        <br>
        <p>Estado:</p>
        <a href="/profile/<?php echo $user['userID'] ?>?page=1&order=<?php echo $order ?>&status=0">Pausado</a>
        <a href="/profile/<?php echo $user['userID'] ?>?page=1&order=<?php echo $order ?>&status=1">Pendiente</a>
        <a href="/profile/<?php echo $user['userID'] ?>?page=1&order=<?php echo $order ?>&status=2">Jugando</a>
        <a href="/profile/<?php echo $user['userID'] ?>?page=1&order=<?php echo $order ?>&status=3">Completado</a>
        <a href="/profile/<?php echo $user['userID'] ?>?page=1&order=<?php echo $order ?>&status=4">Todos</a><br><br>
        <?php
        if (count($games) != 0) {
            foreach ($games as $game) {
                echo $game['gameTitle'] . " " . $game['developers'] . " " . $game['platformName'] . " " . $game['fechaInicio'] . " " . $game['fechaFin'] . " " . $game['statusName'] . " NOTA: " . $game['nota'];
                if ($_SESSION['user']['userID'] == $user['userID']) {
                    echo "<a href='/edit/" . $game['gameID'] . "'> EDIT</a>";
                    ?>&nbsp;&nbsp;<?php
                    echo "<a href='/delete/" . $game['gameID'] . "'> DELETE</a><br>";
                } else {
                    echo "<br>";
                }
            }
        } else {
            echo "No tienes juegos con esas características";
        }
        ?>
                    
        <?php
        if (isset($page)) {
            ?>
            <div class="card shadow mb-4 d-flex">
                <div class="col-2 align-self-center">
                    <span>Página <span><?php echo isset($_GET["page"]) ? $_GET["page"] : ""; ?></span></span>
                    <a class="btn btn-primary" href="/profile/<?php echo $user['userID'] ?>?page=<?php echo $page - 1 < 1 ? 1 : $page - 1 ?>&order=<?php echo isset($order) ? $order : 0 ?>&status=<?php echo isset($status) ? $status : 4 ?>"><<a>
                    <a class="btn btn-primary" href="/profile/<?php echo $user['userID'] ?>?page=<?php echo $maxpage < $page + 1 ? $page : $page + 1 ?>&order=<?php echo isset($order) ? $order : 0 ?>&status=<?php echo isset($status) ? $status : 4 ?>">><a>
                </div>    
            </div>
        <?php
        }
    ?>
    
    <h3>Amigos</h3>
        <?php 
        if(isset($pending)){
            if(count($pending)>0){
                foreach ($pending as $pendiente) {
                    echo "<a href='/profile/".$pendiente['userID']."?page=1&order=0&status=4'>".$pendiente['username']."</a> <a href='/accept/". $pendiente['userID'] ."'>Aceptar</a> <a href='/reject/". $pendiente['userID'] ."'>Rechazar</a>" . "<br>";
                }
            }
        }
        if(isset($friends)){
            foreach ($friends as $friend) {
                echo "<a href='/profile/".$friend['userID']."?page=1&order=0&status=4'>".$friend['username']."</a>" . "<br>";
            }
        }
        ?>
    </body>
</html>