<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            <a href="/search">Añadir juego</a><br>
            <?php
        }
        foreach ($games as $game) {
            echo $game['gameTitle'] . " " . $game['developers'] . " " . $game['platformName'] . " " . $game['fechaInicio'] . " " . $game['fechaFin'] . " " . $game['statusName'];
            if($_SESSION['user']['userID'] == $user['userID']){
                echo "<a href='/edit/". $game['gameID'] ."'> EDIT</a>"; ?>&nbsp;&nbsp;<?php
                echo "<a href='/delete/". $game['gameID'] ."'> DELETE</a><br>";
            }else{
                echo "<br>";
            }
        }
        ?>
        <?php
        if(isset($page)){
        ?>
            <div class="card shadow mb-4 d-flex">
                    <div class="col-2 align-self-center">
                        <span>Página <span><?php echo isset($_GET["page"]) ? $_GET["page"] : ""; ?></span></span>
                        <a class="btn btn-primary" href="/profile/<?php echo $user['userID'] ?>?page=<?php echo $page-1<1 ? 1 : $page-1 ?>"><<a>
                        <a class="btn btn-primary" href="/profile/<?php echo $user['userID'] ?>?page=<?php echo $maxpage<$page+1 ? $page : $page+1 ?>">><a>
                    </div>    
            </div>
        <?php
        }
        ?>

    </body>
</html>