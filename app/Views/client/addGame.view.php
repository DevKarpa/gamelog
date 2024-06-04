<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../assets/css/client/addgame.style.css">
        <link rel="stylesheet" href="../assets/css/client/main.style.css">
        <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
        <link rel="stylesheet" href="../plugins/air-datepicker/air-datepicker.css">
        
        <title><?php echo $game['gameTitle'] ?></title>
    </head>
    <body onload="updateDateValues()">
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
                        <?php
                        
                        if (isset($reg)){
                            $fecha = explode("-", $reg['fechaInicio']);
                            
                            $fecha = implode("/", array_reverse($fecha));
                            
                            $fulldate = $fecha;
                            
                            if($reg['fechaFin']){
                                $fechaf = explode("-", $reg['fechaFin']);
                                //asort($fechaf);
                                $fechaf = implode("/", array_reverse($fechaf));
                                
                                $fulldate .= " - " . $fechaf;
                            }

                        }
                        ?>
                    </ul>
                </nav>
            </header>
            
            <main>
                <?php
                    if (isset($errors)) {
                        echo '<div class="errorbox"><div class="erroritems">';
                            foreach ($errors as $error) {
                                echo "<p>" . $error ."</p>";
                            }
                        echo '</div></div>';
                    }
                ?>
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
                                <select name="status" id="status">
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
                                    <input type="text" id="fecha" name="fecha" value="<?php echo isset($reg) ? $fulldate : '' ?>">
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
                            <input class="btn" type="reset" value="Reset" onclick="resetDateValues()">
                        </div>
                    </form>
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
        <script src="../plugins/jquery/jquery.min.js"></script>
        <script src="../plugins/air-datepicker/air-datepicker.js"></script>
        <script src="../plugins/air-datepicker/es.js"></script>
        <?php include("plugins/dropdownmenu/drop.php"); ?>
        
        <script>

            var fecha = new AirDatepicker('#fecha', {
                range: false
            });

            $('#status').change(function(){
                resetDateValues();
                updateDateValues();
            });
            
            function resetDateValues(){
                $('#fecha').attr('disabled',false);
                $('#fecha').val(' ');
                updateDateValues();
            }
            
            function updateDateValues(){
                switch($('#status').val()){
                    case "3":
                        fecha = new AirDatepicker('#fecha', {
                            range: true,
                            multipleDatesSeparator: " - "
                        });
                        console.log('hooolaaaa');
                        break;
                    case "1":
                        $('#fecha').attr('disabled',true);
                        break;
                    default:
                        fecha = new AirDatepicker('#fecha', {
                            range: false
                        });
                        
                        break;
                }
            }

        </script>
        
    </body>
</html>