<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="assets/css/client/main.style.css">
        <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
        <title><?php echo $game['gameTitle'] ?></title>
    </head>
    <body>
        <a href="/logout">Logout</a><br>
        <a href="/<?php echo !isset($reg) ? 'search' : 'profile/' . $user['userID'] . "?page=1&order=0&status=4" ?>">Back</a>
        <h1><?php echo $game['gameTitle'] // /profile/<?php echo $user['userID']   ?></h1>
        <div style="color:red">
            <?php
            if (isset($errors)) {
                foreach ($errors as $error) {
                    echo $error . "<br><br>";
                }
            }
            ?>
        </div>
        <form action="/<?php echo (isset($reg) ? "edit/" : "add/") . $game['gameID'] ?>" method="post" enctype="multipart/form-data">
            > Inicio: <input type="date" id="start" name="start" value="<?php echo isset($reg) ? $reg['fechaInicio'] : '' ?>"><br>
            > Final: <input type="date" id="end" name="end" value="<?php echo isset($reg) ? $reg['fechaFin'] : '' ?>"><br><br>
            > Notas: (Opcional)<br> <textarea name="note"><?php echo isset($reg) ? $reg['nota'] : '' ?></textarea><br><br>
            Status:
            <select name="status" id="status">
                <?php
                            foreach ($statusList as $status) {
                                $selected = isset($reg) ? $reg['statusID']==$status['statusID'] ? "selected" : " " : " ";
                                echo "<option value=". $status['statusID'] ." " . $selected . ">".$status['statusName']."</option>";
                            }
                ?>
                
            </select><br><br>
            <input type="submit" name="submit" id="submit" value="Enviar">
            <input type="reset" value="Reset" onclick="resetValues()">
        </form>
        
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
        
        <script>
            var start = document.getElementById('start');
            var end = document.getElementById('end');
            var status = document.getElementById('status');

            // Por alguna razon solo funciona en /add porque 
            // no puede sobreescribir los datos escritos por PHP
            function resetValues(){
                start.value = "";
                end.value = "";
                status.value = 0;
                
            }
        </script>
    </body>
</html>