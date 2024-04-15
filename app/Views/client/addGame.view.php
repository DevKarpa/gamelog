<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $game['gameTitle'] ?></title>
    </head>
    <body>
        <a href="/logout">Logout</a><br>
        <a href="/<?php echo !isset($reg) ? 'search' : 'profile/' . $user['userID'] . "?page=1" ?>">Back</a>
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