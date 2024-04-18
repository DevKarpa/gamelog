<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gamelog | Index</title>
</head>
<body>
    <h1>Bienvenid@ a Gamelog</h1>
    <?php
        if(isset($_SESSION['user'])){
            ?> <a href="/logout">Logout</a> 
               <h2><a href="/profile/<?php echo $_SESSION['user']['userID'] ?>?page=1&order=0&status=4">Mi perfil</a></h2>
                <?php
        }else{
            ?> <a href="/login">Iniciar Sesión</a> <?php
            ?> <a href="/register">Registrarse</a> <?php
        }
    ?>
    
    
    <h2><a href="/search">Buscar juegos</a></h2>
</body>
</html>