<div class="row">       
    <div class="col-12">
        <?php
        /**
        if(isset($error)){
            ?> <div class="alert alert-warning"><p>No está permitido darse de baja a uno mismo.</p></div> <?php
        }**/
        ?>
        
    </div>
    <div class="col-12">
        <div class="card shadow mb-4">
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <div class="col-6">
                    <h6 class="m-0 installfont-weight-bold text-primary">Game list</h6> 
                </div>
                <div class="col-6">
                    <div class="m-0 font-weight-bold justify-content-end">
                        <a href="/game-list/add/" class="btn btn-warning ml-1 float-right"> Add new game &nbsp;<i class="fas fa-plus-circle"></i></a>
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
                            <th>Game</th>                          
                            <th>Year</th>                            
                            <th>Score</th>
                            <th>Developer/s</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php
                            foreach ($games as $game) {
                                echo "<tr>";
                                echo "<td>".$game['gameID']."</td>";
                                echo "<td>".$game['gameTitle']."</td>";
                                echo "<td>".$game['gameYear']."</td>";
                                echo "<td>".$game['gameScore']."</td>";
                                echo "<td>".$game['developers']."</td>";
                                ?>
                        
                            <td><a href="/game-list/edit/<?php echo $game['gameID']?>" class="btn btn-success"><i class="fas fa-edit"></i></a>
                                <a href="/game-list/hide/<?php echo $game['gameID']?>" class="btn btn-primary"> <i class="fas fa-toggle-off"></i></a>
                                <a href="/game-list/delete/<?php echo $game['gameID']?>" class="btn btn-danger"><i class="fas fa-trash"></i></a></td></tr>
                                <?php
                            }
                            ?>
                        
                    </tbody>
                    <tfoot>
                        Game count: <?php echo count($games); ?>                        </tfoot>
                </table>
            </div>
        </div>
    </div>                        
</div>