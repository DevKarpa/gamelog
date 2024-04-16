<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gamelog | Index</title>
</head>
<body>
    <a href="/logout">Logout</a>
    <h1>Bienvenid@ a Gamelog</h1>
    <h2><a href="/profile/<?php echo $_SESSION['user']['userID'] ?>?page=1&order=0&status=4">Mi perfil</a></h2>
    <h2><a href="/search">Buscar juegos</a></h2>
</body>
</html>