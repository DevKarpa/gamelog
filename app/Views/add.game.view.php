<!-- Content Row -->

<div class="row">
    <div class="col-12">
        <?php
        if (isset($errores)) {
            if (count($errores) == 0) {
                ?> <div class="alert alert-success"><p><?php echo "Juego añadido exitosamente" ?></p></div> <?php
            }
        }
        ?>
    </div>
    <div class="col-12">
        <div class="card shadow mb-4">
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Introduzca los datos del nuevo juego</h6>                                    
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <?php //var_dump($inputd);  ?>
                <form action="/game-list/<?php echo isset($input) ? 'edit/' . $input['gameID'] : 'add/' ?>" method="post" enctype="multipart/form-data">         
                    <!--form method="get"-->
                    <div class="row">

                        <div class="mb-3 col-sm-6">
                            <label for="cif">Nombre del juego</label>
                            <input class="form-control" id="name" type="text" name="name" placeholder="Título del juego..." value="<?php echo isset($input['gameTitle']) ? $input['gameTitle'] : ''; ?>" <?php echo isset($edit) ? "" : "required" ?>>
                            <p class="text-danger"><?php echo isset($errores['name']) ? $errores['name'] : ''; ?></p>
                        </div>

                        <div class="mb-3 col-sm-2">
                            <label for="codigo">Año de salida</label>
                            <input class="form-control" id="year" type="text" name="year" placeholder="0000" value="<?php echo isset($input['gameYear']) ? $input['gameYear'] : ''; ?>" <?php echo isset($edit) ? "" : "required" ?>>
                            <p class="text-danger"><?php echo isset($errores['year']) ? $errores['year'] : ''; ?></p>
                        </div>

                        <div class="mb-3 col-sm-4">
                            <label for="platform">Plataforma</label>
                            <select class="form-control select2" name="platform" required>

                                <?php
                                foreach ($platforms as $platform) {
                                    $selected = isset($input['platformID']) ? $input['platformID'] == $platform['platformID'] ? "selected" : "" : "";
                                    echo "<option value='" . $platform['platformID'] . "' " . $selected . ">" . $platform['platformName'] . "</option>";
                                }
                                ?>

                            </select>
                        </div>

                        <div class="mb-3 col-sm-6">
                            <label for="devs">Desarrolladora/s</label>
                            <?PHP // var_dump( in_array(3, $inputd) );  ?>
                            <select class="form-control js-example-basic-multiple" name="devs[]" multiple="multiple" required>

                                <?php
                                foreach ($devs as $dev) {

                                    $selected = isset($inputd) ? in_array($dev['devID'], $inputd['devID']) ? "selected" : " " : "";
                                    echo "<option value=" . $dev['devID'] . $selected . ">" . $dev['devName'] . "</option>";
                                }
                                ?>

                            </select>
                        </div>



                        <div class="mb-3 col-sm-6">
                            <label for="codigo">Steam Grid (Aspect Ratio 92 : 43) <a title="Ayuda con la imagen" href="imghelp">?</a></label>
                            <input class="form-control-file" id="image" type="file" name="image" accept="image/*" required>
                            <p class="text-danger"><?php echo isset($errores['image']) ? $errores['image'] : ''; ?></p>
                        </div>

                        <div class="col-12 text-right">                            
                            <input type="submit" value="Enviar" name="submit" class="btn btn-primary"/>
                            <a href="/game-list" class="btn btn-danger ml-3">Cancelar</a>                            
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>                        
</div>