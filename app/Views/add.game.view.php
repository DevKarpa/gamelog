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
                <form action="/usuarios-sistema/<?php echo isset($edit) ? 'edit/' . $id : 'add' ?>" method="post">         
                    <!--form method="get"-->
                    <div class="row">
                        <div class="mb-3 col-sm-6">
                            <label for="cif">Nombre del juego</label>
                            <input class="form-control" id="email" type="text" name="email" placeholder="Fortnite..." value="<?php echo isset($input['email']) ? $input['email'] : ''; ?>" <?php echo isset($edit) ? "" : "required" ?>>
                                   <p class="text-danger"><?php echo isset($errores['email']) ? $errores['email'] : ''; ?></p>
                        </div>
                        <div class="mb-3 col-sm-6">
                            <label for="codigo">Año de salida</label>
                            <input class="form-control" id="username" type="text" name="username" placeholder="Nombre de usuario" value="<?php echo isset($input['username']) ? $input['username'] : ''; ?>" <?php echo isset($edit) ? "disabled" : "required" ?>>
                                   <p class="text-danger"><?php echo isset($errores['username']) ? $errores['username'] : ''; ?></p>
                        </div>
                        <div class="mb-3 col-sm-6">
                            <label for="nombre">Nota</label>
                            <input class="form-control" id="password" type="password" name="password" placeholder="Contraseña" value="<?php echo isset($input['password']) ? $input['password'] : ''; ?>"  <?php echo isset($edit) ? "" : "required" ?>>
                                   <p class="text-danger"><?php 
                                   
                                   if(isset($errores['password'])){
                                       for ($i = 0; $i < count($errores['password']); $i++) {
                                           echo $errores['password'][$i] . "<br>";
                                       }
                                   }
                                   
                                   ?></p>

                        </div>
                       
                        <div class="mb-3 col-sm-6">
                            <label for="rol">Desarrolladora/s</label>
                            <select class="form-control select2" name="devs[]" multiple>
                                
                                <?php
                               /** foreach ($devs as $dev) {
                                    echo "<option value=" . $dev['devID'] . ">" . $rol['devName'] . "</option>";
                                }
                                **/
                                ?>
                                <option value=1>s</option>
                                <option value=3>suuu</option>
                                
                            </select>

                        </div>
                        <div class="mb-3 col-sm-6">
                            <label for="codigo">Steam Grid (Aspect Ratio 92 : 43)</label>
                            <input class="form-control-file" id="username" type="file" name="username" accept="image/png, image/jpeg">
                                   <p class="text-danger"></p>
                        </div>
                        <div class="col-12 text-right">                            
                            <input type="submit" value="Enviar" name="enviar" class="btn btn-primary"/>
                            <a href="/usuarios-sistema" class="btn btn-danger ml-3">Cancelar</a>                            
                        </div>
                    </div>
                </form>
                
            </div>
        </div>
    </div>                        
</div>