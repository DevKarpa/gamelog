<style>
    #grid{
        width:120px;
    }
</style>
<div class="row">       
    <div class="col-12">
        <?php
        if(isset($deletedDev)){
                ?> <div class="alert alert-success"><p>El desarrollador <?php echo $deletedDev['devName'] ?> ha sido borrado correctamente.</p></div> <?php
        }
        ?>
    </div>
    <div class="col-12">
        <div class="card shadow mb-4">
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <div class="col-6">
                    <h6 class="m-0 installfont-weight-bold text-primary">Lista de desarrolladores</h6> 
                </div>
                <div class="col-6">
                    <div class="m-0 font-weight-bold justify-content-end">
                        <a href="/dev-list/add/" class="btn btn-warning ml-1 float-right"> Añadir nuevo desarrollador &nbsp;<i class="fas fa-plus-circle"></i></a>
                    </div>
                </div>
            </div>
            <!-- Card Body -->
            <div class="card-body" id="card_table">
                <div id="button_container" class="mb-3"></div>
                <!--<form action="./?sec=formulario" method="post">                   -->
                <table id="tabladatos" class="table table-striped">                    
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>                          
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php                                
                            foreach ($devs as $dev) {
                                
                                echo "<tr>";
                                echo "<td>".$dev['devID']."</td>";
                                echo "<td>".$dev['devName']."</td>";
                                if($dev['devID']!=1){

                                ?>
                                
                            <td>
                                <a href="/dev-list/delete/<?php echo $dev['devID']?>" class="btn btn-danger"><i class="fas fa-trash"></i></a></td></tr>
                                <?php
                                }
                            }
                            ?>
                        
                    </tbody>
                    <tfoot>Número de devs: <?php echo count($devs); ?></tfoot>
                </table>
            </div>
        </div>
    </div>                        
</div>