<!-- Content Row -->

<div class="row">

    <div class="col-12">
        <div class="card shadow mb-4">
            <?php   
            if(isset($errores)){
                if(count($errores)==0){
                    echo "Usuario editado exitosamente";
                }   
            }     
            ?>
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Introduzca los datos del usuario a editar</h6>                                    
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <form action="/user-list/<?php echo 'edit/' . $id ?>" method="post" enctype="multipart/form-data">         
                    <!--form method="get"-->
                    <div class="row">
                        
                        <div class="mb-3 col-sm-6">
                            <label for="cif">Nombre de usuario</label>
                            <input class="form-control" id="name" type="text" name="name" value="<?php echo isset($user['username']) ? $user['username'] : ''; ?>" required >
                                   <p class="text-danger"><?php echo isset($errores['name']) ? $errores['name'] : ''; ?></p>
                        </div>
                        
                        <div class="mb-3 col-sm-3">
                            <label for="cif">Contraseña</label>
                            <input class="form-control" id="pass" type="password" name="pass">
                            <p class="text-danger"><?php var_dump($errores['pass']) ?></p>
                        </div>
                        
                        <div class="mb-3 col-sm-3">
                            <label for="cif">Repetir contraseña</label>
                            <input class="form-control" id="pass2" type="password" name="pass2">
                        </div>
                        
                        <div class="mb-3 col-sm-4">
                            <label for="type">Tipo de usuario</label>
                            <select class="form-control select2" name="type" required>
                                
                                <option value="0" <?php echo $user['userType']==0 ? "selected" : "" ?> >Usuario Cliente</option>
                                <option value="1" <?php echo $user['userType']==1 ? "selected" : "" ?> >Administrador</option>
 
                            </select>
                        </div>
                        
                        <div class="col-12 text-right">                            
                            <input type="submit" value="Enviar" name="submit" class="btn btn-primary"/>
                            <a href="/user-list" class="btn btn-danger ml-3">Cancelar</a>                            
                        </div>
                    </div>
                </form>
                
            </div>
        </div>
    </div>                        
</div>