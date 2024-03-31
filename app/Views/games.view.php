<style>
    #grid{
        width:120px;
    }
</style>
<div class="row">       
    <div class="col-12">
        <?php
        if (isset($deletedGame)) {
            ?> <div class="alert alert-success"><p>El juego <?php echo $deletedGame ?> ha sido borrado correctamente.</p></div> <?php
        }
        ?>
    </div>
    <div class="col-12">
        <div class="card shadow mb-4">
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <div class="col-6">
                    <h6 class="m-0 installfont-weight-bold text-primary">Lista de juegos</h6> 
                </div>
                <div class="col-6">
                    <div class="m-0 font-weight-bold justify-content-end">
                        <a href="/game-list/add/" class="btn btn-warning ml-1 float-right"> Añadir nuevo juego &nbsp;<i class="fas fa-plus-circle"></i></a>
                    </div>
                </div>
            </div>
            <!-- Card Body -->
            <div class="card-body" id="card_table">
                <form action="/game-list" method="post">
                    <div class="row">

                        <div class="col-12 col-lg-3">
                            <div class="mb-3">
                                <label for="name">Nombre:</label>
                                <input type="text" class="form-control" name="name" id="name" value="" />
                            </div>
                        </div>  


                        <div class="col-12 col-lg-3">
                            <div class="mb-3">
                                <label for="retencion">Año:</label>
                                <input type="number" class="form-control" name="year" id="year" value="" placeholder="0000" />
                            </div>
                        </div>      
                        <div class="col-12 col-lg-3">
                            <div class="mb-3">
                                <label for="devID">Desarrolladores:</label>
                                <select name="devID[]" class="form-control js-example-basic-multiple" multiple>
                                    <?php
                                    foreach ($devs as $dev) {
                                        echo "<option value='" . $dev['devID'] . "'>" . $dev['devName'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-lg-3">
                            <div class="mb-3">
                                <label for="plataforma">Plataforma:</label>
                                <select name="plataforma" class="form-control">
                                    <option value="">-</option>
                                    <?php
                                    foreach ($platforms as $plat) {
                                        echo "<option value='" . $plat['platformID'] . "'>" . $plat['platformName'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 text-right">                            
                            <input type="submit" value="Buscar" name="submit" class="btn btn-primary"/>
                            <a href="/game-list?page=1" class="btn btn-danger ml-3">Reiniciar</a>                            
                        </div>
                    </div>
                </form>
                <div id="button_container" class="mb-3"></div>
                <!--<form action="./?sec=formulario" method="post">                   -->
                <table id="tabladatos" class="table table-striped">                    
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>                          
                            <th>Año</th>                            
                            <th>Desarrollador/es</th>
                            <th>Plataforma</th>
                            <th>Imagen</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($games as $game) {
                            echo "<tr>";
                            echo "<td>" . $game['gameID'] . "</td>";
                            echo "<td>" . $game['gameTitle'] . "</td>";
                            echo "<td>" . $game['gameYear'] . "</td>";
                            echo "<td>" . $game['developers'] . "</td>";
                            echo "<td>" . $game['platformName'] . "</td>";
                            ?>

                        <td><img id="grid" src="assets/img/games/<?php echo $game['gameID'] ?>.png"></td>

                        <td><a href="/game-list/edit/<?php echo $game['gameID'] ?>" class="btn btn-success"><i class="fas fa-edit"></i></a>
                            <a href="/game-list/delete/<?php echo $game['gameID'] ?>" class="btn btn-danger"><i class="fas fa-trash"></i></a></td></tr>
                        <?php
                    }
                    ?>

                    </tbody>
                    <tfoot>Número total de juegos: <?php echo count($allgames); ?></tfoot>
                </table>

            </div>

        </div>
        <?php
        if(isset($page)){
            ?>
        <div class="card shadow mb-4 d-flex">
                <div class="col-2 align-self-center">
                    <span>Página <span><?php echo isset($_GET["page"]) ? $_GET["page"] : ""; ?></span></span>
                    <a class="btn btn-primary" href="/game-list?page=<?php echo $page-1<1 ? 1 : $page-1 ?>"><<a>
                    <a class="btn btn-primary" href="/game-list?page=<?php echo $maxpage<$page+1 ? $page : $page+1 ?>">><a>
                </div>    
        </div>
        <?php
        }
        ?>
    </div>                        
</div>