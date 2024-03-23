<!-- Content Row -->

<div class="row">

    <div class="col-12">
        <div class="card shadow mb-4">
            <?php
            
            if(isset($errores)){
                
                if(count($errores)==0){
                    echo "Juego añadido exitosamente";
                }
                
            }
            
            ?>
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Introduzca los datos del nuevo juego</h6>                                    
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <form action="/game-list/<?php echo isset($edit) ? 'edit/' . $id : 'add' ?>" method="post" enctype="multipart/form-data">         
                    <!--form method="get"-->
                    <div class="row">
                        
                        <div class="mb-3 col-sm-6">
                            <label for="cif">Nombre del juego</label>
                            <input class="form-control" id="name" type="text" name="name" value="<?php echo isset($input['name']) ? $input['name'] : ''; ?>" <?php echo isset($edit) ? "" : "required" ?>>
                                   <p class="text-danger"><?php echo isset($errores['name']) ? $errores['name'] : ''; ?></p>
                        </div>
                        
                        <div class="mb-3 col-sm-6">
                            <label for="codigo">Año de salida</label>
                            <input class="form-control" id="year" type="text" name="year" placeholder="0000" value="<?php echo isset($input['year']) ? $input['year'] : ''; ?>" <?php echo isset($edit) ? "" : "required" ?>>
                                   <p class="text-danger"><?php echo isset($errores['year']) ? $errores['year'] : ''; ?></p>
                        </div>
                        
                        <div class="mb-3 col-sm-6">
                            <label for="nombre">Nota</label>
                            <input class="form-control" id="score" type="number" min="1" max="100" name="score"  value="<?php echo isset($input['score']) ? $input['score'] : ''; ?>"  <?php echo isset($edit) ? "" : "required" ?>>
                                   <p class="text-danger"><?php echo isset($errores['score']) ? $errores['score'] : '';?></p>
                        </div>
                        
                        <div class="mb-3 col-sm-6">
                            <label for="devs">Desarrolladora/s</label>
                            <select class="form-control select2" name="devs[]" multiple required>
                                
                                <?php
                                foreach ($devs as $dev) {
                                    echo "<option value=" . $dev['devID'] . ">" . $dev['devName'] . "</option>";
                                }
                                ?>
 
                            </select>
                        </div>
                        
                        <div class="mb-3 col-sm-6">
                            <label for="codigo">Steam Grid (Aspect Ratio 92 : 43)</label>
                            <input class="form-control-file" id="image" type="file" name="image" accept="image/png" required>
                                   <p class="text-danger"><?php echo isset($errores['image']) ? $errores['image'] : '';?></p>
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