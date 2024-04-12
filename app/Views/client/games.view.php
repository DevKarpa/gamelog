<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>LISTA DE JUEGOS</title>
    </head>
    <body>
        <a href="/logout">Logout</a><br>
        <a href="/">Back</a>
        <h1>BARRA DE BUSQUEDA GRANDE</h1>
        <form>
            Juego: <input type="text" onkeyup="showGame(this.value)">
        </form>
        <div id="gamelist"></div>
        <script>
            gamelist = document.getElementById('gamelist');

            function showGame(txt) {
                if (txt.length != 0) {

                    var xmlhttp = new XMLHttpRequest();

                    xmlhttp.onreadystatechange = function () {
                        if (this.readyState == 4 && this.status == 200) {
                            gamelist.innerHTML = this.responseText;
                        }
                    }

                    // La dirección cambia si la web está hosteada en remoto
                    xmlhttp.open("GET", "http://gamelog.localhost:8080/async/" + txt.toLowerCase(), true);
                    xmlhttp.send();

                } else {
                    gamelist.innerHTML = "";
                }
                
            }
        </script>
    </body>
</html>