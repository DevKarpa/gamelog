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
        <!-- Tailwind CSS -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
        <!-- icheck bootstrap -->
        <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="assets/css/adminlte.min.css">
        <link rel="stylesheet" href="assets/css/client/login.style.css"
    </head>
    <body class="hold-transition">
        
        <section class="bg-gray-900 min-h-screen flex items-center justify-center">
          <div class="flex flex-col items-center justify-center px-6 py-12 mx-auto w-full max-w-md">
            <a href="#" id="title" class="flex items-center mb-6 text-2xl font-semibold text-white">
              GAMELOG
            </a>
            <div class="w-full bg-gray-800 rounded-lg shadow border border-gray-700">
              <div class="p-8 space-y-6">
                <h1 class="login-title text-xl font-bold leading-tight tracking-tight text-white md:text-2xl">
                  <?php echo isset($register) ? "Regístrate" : "Iniciar sesión" ?>
                </h1>
                <form class="space-y-4" action="/<?php echo isset($register) ? "register" : "login" ?>" method="post">
                  <div>
                    <label for="username" class="block mb-2 text-sm font-medium text-white">Nombre de usuario</label>
                    <input type="text" name="username" id="username" class="bg-gray-700 border border-gray-600 text-white sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 placeholder-gray-400" placeholder="Username" required>
                    <p class="mt-2 text-sm text-red-400"><?php echo isset($errors['username']) ? $errors['username'] : '' ?></p>
                  </div>
                  <div>
                    <label for="password" class="block mb-2 text-sm font-medium text-white">Contraseña</label>
                    <input type="password" name="pass" id="password" placeholder="••••••••" class="bg-gray-700 border border-gray-600 text-white sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 placeholder-gray-400" required>
                    <p class="mt-2 text-sm text-red-400"><?php if(isset($errors['password'])){ foreach ($errors['password'] as $err) { echo $err . "<br>"; } } ?></p>
                  </div>
                  <?php if (isset($register)) { ?>
                  <div>
                    <label for="confirm-password" class="block mb-2 text-sm font-medium text-white">Repetir Contraseña</label>
                    <input type="password" name="pass2" id="confirm-password" placeholder="••••••••" class="bg-gray-700 border border-gray-600 text-white sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 placeholder-gray-400" required>
                  </div>
                  <?php } ?>
                  <p class="mt-2 text-sm text-red-400"><?php echo isset($error) ? $error : '' ?></p>
                  <div class="flex items-center justify-between">
                    <p class="text-sm font-light text-gray-400">
                      <?php echo isset($register) ? "¿Tienes cuenta?" : "¿No tienes cuenta?" ?> 
                      <a href='<?php echo isset($register) ? "login" : "register" ?>' class="font-medium text-blue-500 hover:underline">
                        <?php echo isset($register) ? "¡Inicia Sesión!" : "¡Regístrate!" ?>
                      </a>
                    </p>
                  </div>
                  <button type="submit" name="submit" class="w-full tsubmitext-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    <?php echo isset($register) ? "Registrarse" : "Iniciar Sesión" ?>
                  </button>
                </form>
              </div>
            </div>
          </div>
        </section>
        
        
        <!-- /.login-box -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
        <!-- jQuery -->
        <script src="plugins/jquery/jquery.min.js"></script>
        <!-- Bootstrap 4 -->
        <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- AdminLTE App -->
        <script src="dist/js/adminlte.min.js"></script>
    </body>
</html>
