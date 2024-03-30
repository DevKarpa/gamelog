<!-- Content Row -->

<div class="row">
<div class="col-12">
        <?php
        if(isset($errores)){
            if (count($errores) == 0) {
                ?> <div class="alert alert-success"><p><?php echo "Desarrolladores añadidos con éxito" ?></p></div> <?php
            }
            
        }
        ?>
    </div>
    <div class="col-12">
        <div class="card shadow mb-4">
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Introduzca nuevos desarrolladores</h6>                                    
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <form action="/dev-list/add" method="post" enctype="multipart/form-data">         
                    <!--form method="get"-->
                    <div class="row">

                        <div class="mb-3 col-sm-12">
                            <label for="cif">Añadir desarrolladores (Separados por "," o Enter)</label>
                            <select class="form-control js-example-tokenizer" name="devs[]" multiple="multiple">
                            </select>
                            <p class="text-danger"><?php
                                if (isset($errores)) {
                                    foreach ($errores as $error) {
                                        echo $error . "<br>";
                                    }
                                }
                                ?></p>
                        </div>

                        <div class="col-12 text-right">                            
                            <input type="submit" value="Enviar" name="submit" class="btn btn-primary"/>
                            <a href="/dev-list" class="btn btn-danger ml-3">Cancelar</a>                            
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>                        
</div>