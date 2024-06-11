<!DOCTYPE html>
<html lang="en">
<head>
  <base href="/">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Gamelog | Backend</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/css/adminlte.min.css">
  <!-- Select 2 -->
  <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
  <!-- favicon -->
  <link rel="icon" type="image/x-icon" href="assets/img/favicon.png">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper"> 
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>      
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">      
          <a href="logout" class="nav-link"><i class="text-danger fas fa-sign-out-alt"></i></a>   
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>      
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
      <img src="assets/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Gamelog Admin</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="assets/img/profile/<?php echo $_SESSION['user']['userID'] ?>.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo isset($_SESSION['user']) ? $_SESSION['user']['username'] : 'none' ?></a>
        </div>
      </div>
     
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="/" class="nav-link active">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Inicio
              </p>
            </a>
          </li> 
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Panel de control
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/game-list?page=1" class="nav-link <?php echo isset($seccion) && $seccion === 'game-list' ? 'active' : ''; ?>">
                  <i class="fas fa-gamepad nav-icon"></i>
                  <p>Lista de juegos</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/user-list" class="nav-link <?php echo isset($seccion) && $seccion === 'user-list' ? 'active' : ''; ?>">
                  <i class="fas fa-user nav-icon"></i>
                  <p>Lista de usuarios</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/dev-list" class="nav-link <?php echo isset($seccion) && $seccion === 'dev-list' ? 'active' : ''; ?>">
                  <i class="fas fa-code nav-icon"></i>
                  <p>Lista de desarrolladores</p>
                </a>
              </li>
            </ul>
          </li>                   
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><?php             
            echo isset($titulo) ? $titulo : '' ?></h1>
          </div><!-- /.col -->
          <?php 
          
          if(isset($breadcrumb) && is_array($breadcrumb)){
              ?>          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <?php    
                
                foreach($breadcrumb as $b){
                ?>
              <li class="breadcrumb-item"><?php echo $b; ?></li>             
              <?php
                }?>
            </ol>
          </div><!-- /.col -->
          <?php
          }
          ?>
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

<section class="content">
      <div class="container-fluid">