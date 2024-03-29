<div class="row">       
    <div class="col-12">
        <?php
        if(isset($error)){
            ?> <div class="alert alert-danger"><p><?php echo $error ?></p></div> <?php
        }
        if(isset($deletedUser)){
            ?> <div class="alert alert-success"><p>Usuario <?php echo $deletedUser ?> elminado con éxito.</p></div> <?php
        }
        ?>
    </div>
    <div class="col-12">
        <div class="card shadow mb-4">
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <div class="col-6">
                    <h6 class="m-0 installfont-weight-bold text-primary">Lista de usuarios</h6> 
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
                            <th>Nombre de usuario</th>                          
                            <th>Tipo</th>                            
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php                                
                            foreach ($users as $user) {
                                $type = $user['userType'] ? "Administrador" : "Usuario";
                                echo "<tr>";
                                echo "<td>".$user['userID']."</td>";
                                echo "<td>".$user['username']."</td>";
                                echo "<td>". $type ."</td>";
                                ?>
                        
                            <td><a href="/user-list/edit/<?php echo $user['userID']?>" class="btn btn-success"><i class="fas fa-edit"></i></a>
                                <a href="/user-list/delete/<?php echo $user['userID']?>" class="btn btn-danger"><i class="fas fa-trash"></i></a></td></tr>
                                <?php
                            }
                            ?>
                        
                    </tbody>
                    <tfoot> Número de usuarios registrados: <?php echo count($users); ?> </tfoot>
                </table>
            </div>
        </div>
    </div>                        
</div>