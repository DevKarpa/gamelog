<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../assets/css/client/addgame.style.css">
        <link rel="stylesheet" href="../assets/css/client/main.style.css">
        <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
        
        <title><?php echo $game['gameTitle'] ?></title>
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
                
                <section class="midPage">
                    <section class="gameData">
                        <div class='gameImg'>
                            <div class="popularGameItem"><span><?php echo $game['gameTitle'] ?></span><?php echo "<img src='../assets/img/games/" . $game['gameID'] . ".png'>" ?></div>
                        </div>
                    </section>

                    <section class="userData">
                        <form action="/<?php echo (isset($reg) ? "edit/" : "add/") . $game['gameID'] ?>" method="post" enctype="multipart/form-data">
                            <div class="statusItem">
                                <label>Status</label>
                                <select name="status" id="status" onchange="changeColor()">
                                    <?php
                                                foreach ($statusList as $status) {
                                                    $selected = isset($reg) ? $reg['statusID']==$status['statusID'] ? "selected" : " " : " ";
                                                    echo "<option value=". $status['statusID'] ." " . $selected . ">".$status['statusName']."</option>";
                                                }
                                    ?>

                                </select>
                            </div>
                            <div class="datesItem">
                                <div class="dItem">
                                    <label>Inicio</label>
                                    <input type="date" id="start" name="start" value="<?php echo isset($reg) ? $reg['fechaInicio'] : '' ?>">
                                </div>
                                <div class="dItem">
                                   <label>Fin</label>
                                    <input type="date" id="end" name="end" value="<?php echo isset($reg) ? $reg['fechaFin'] : '' ?>">
                                </div>
                            </div>
                            <div class="noteItem">
                                <label>Nota (Opcional)</label>
                                <input id="nota" name="note" type="number" min="0" max="100" value="<?php echo isset($reg) ? $reg['nota'] : '' ?>">
                            </div>
                            
                        
                    </section>
                    
                </section>
                
                <section class="bottomPage">
                        <div class="buttonsItem">
                            <input class="btn" type="submit" name="submit" id="submit" value="Enviar">
                            <input class="btn" type="reset" value="Reset" onclick="resetValues()">
                        </div>
                    </form>
                        <?php
                    if (isset($errors)) {
                        echo '<div class="errorbox"><div class="erroritems">';
                            foreach ($errors as $error) {
                                echo "<p>" . $error ."</p>";
                            }
                        echo '</div></div>';
                    }
                ?>
                </section>

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
            
            function changeColor(){
                console.log("PAUSADO ⏸️");
                console.log("PENDIENTE ⌛️");
                console.log("JUGANDO 🎮️");
                console.log("JUGANDO ✅️");
            }
            
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