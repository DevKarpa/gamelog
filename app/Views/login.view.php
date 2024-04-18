<!DOCTYPE html>
<html lang="en">
    <head>
        <base href="/">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Gamelog | Log in</title>

        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
        <!-- icheck bootstrap -->
        <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="assets/css/adminlte.min.css">
    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                <a href="#"><b>GAME</b>LOG</a>
            </div>
            <!-- /.login-logo -->  
            <div class="card">
                <div class="card-body login-card-body">
                    <p class="login-box-msg"><?php echo isset($register) ? "Regístrate" : "Autentícate para iniciar sesión" ?></p>
                    <form action="/<?php echo isset($register) ? "register" : "login" ?>" method="post">
                        <div class="input-group mb-3">
                            <input type="text" name="username" class="form-control" placeholder="Username">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>
                        <p class="login-box-msg text-danger"><?php echo isset($errors['username']) ? $errors['username'] : '' ?></p>  
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" name="pass" placeholder="Password">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <p class="login-box-msg text-danger"><?php 
                        
                        if(isset($errors['password'])){
                            foreach ($errors['password'] as $err) {
                                echo $err . "<br>";
                            }
                        }
                        
                        ?></p>  
                            <?php
                            if (isset($register)) {
                                ?>
                                <div class="input-group mb-3">
                                    <input type="password" class="form-control" name="pass2" placeholder="Confirm Password">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-lock"></span>
                                        </div>
                                    </div>  
                                </div>
                                    <?php
                                }
                                ?>
                                

                            <p class="login-box-msg text-danger"><?php echo isset($error) ? $error : '' ?></p>      
                            <p class="login-box-msg"> <?php echo isset($register) ? "¿Tienes cuenta?" : "¿No tienes cuenta?" ?> <a href='<?php echo isset($register) ? "login" : "register" ?>'> <?php echo isset($register) ? "¡Inicia Sesión!" : "¡Regístrate!" ?> </a></p>
                            <div class="row">
                                <div class="col-12">            
                                    <button name="submit" type="submit" class="btn btn-<?php echo isset($register) ? "danger" : "primary" ?> btn-block float-right"> <?php echo isset($register) ? "Registrarse" : "Iniciar Sesión" ?> </button>
                                </div>
                                <!-- /.col -->
                            </div>
                    </form>

                    <!-- /.login-card-body -->
                </div>
            </div>
            <!-- /.login-box -->

            <!-- jQuery -->
            <script src="plugins/jquery/jquery.min.js"></script>
            <!-- Bootstrap 4 -->
            <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
            <!-- AdminLTE App -->
            <script src="dist/js/adminlte.min.js"></script>
    </body>
</html>
