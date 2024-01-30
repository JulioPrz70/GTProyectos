<?php
session_start();

//Validamos si la sesion esta activa
if (!$_SESSION['activo']) {
  header("Location:panel.php");
}

//Obtener demas varaiables de sesión
$idAlumno = $_SESSION['idAlumno'];
$nombre = $_SESSION['nombre'];
$apellidos = $_SESSION['apellidos'];
$email = $_SESSION['email'];
$es_admin = $_SESSION['esAdmin'];


//Incluir la conexion y queda de manera global para todos los archivos
include_once("conexion_sql.php");
?>

<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Proyectos GT - TECNM HOPELCHÉN</title>

  <link rel="icon" href="dist/img/tecnm.jpg" type="opacity: .8">
  <link rel="shortcut icon" href="dist/img/tecnm.jpg" type="opacity: .8">

  
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
 
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<scrip class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>     
    </ul>   

    
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link">
      <img src="dist/img/tecnm.jpg" alt="Tecnm Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">PROYECTOS GT</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
        <?php if(isset($_SESSION['activo']) && $_SESSION['sexo'] == "H") : ?>
          <img src="dist/img/avatar5.png" class="img-circle elevation-2" alt="User Image">
          <ion-icon name="person-circle-sharp"></ion-icon>
        <?php endif; ?>
        <?php if(isset($_SESSION['activo']) && $_SESSION['sexo'] == "M") : ?>
          <img src="dist/img/avatar2.png" class="img-circle elevation-2" alt="User Image">
          <ion-icon name="person-circle-sharp"></ion-icon>
        <?php endif; ?>
        </div>
        <div class="info">         
          <p class="text-white"><?php echo $nombre." ".$apellidos;?></p>
          <p class="text-white"><?php echo $email; ?></p>
          <!--<p class="text-white"><?php //echo $idAlumno; ?></p>-->
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
         
          <li class="nav-item">
            <a href="panel.php" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Panel de control        
              </p>
            </a>
          </li>

          <?php if(isset($_SESSION['activo']) && $_SESSION['esAdmin'] == 0) : ?>
          <li class="nav-item">
            <a href="lista_proyectos.php" class="nav-link">
              <i class="nav-icon fas fas fa-folder"></i>
              <p>
                Mis Proyectos     
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="lista_actividades.php" class="nav-link">
              <i class="nav-icon fas fas fa-file"></i>
              <p>
                  Actividades     
              </p>
            </a>
          </li>
          <?php endif; ?>
          
          <?php if(isset($_SESSION['activo']) && $_SESSION['esAdmin'] == 1) : ?>
            <li class="nav-item">
              <a href="todos_proyectos.php" class="nav-link">
                <i class="nav-icon fas fa-folder"></i>
                <p>
                  Proyectos     
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="todas_actividades.php" class="nav-link">
                <i class="nav-icon fas fa-file"></i>
                <p>
                  Actividades     
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="lista_alumnos.php" class="nav-link">
                <i class="nav-icon fas fa-users"></i>
                <p>
                  Estudiantes      
                </p>
              </a>
            </li>
            <?php endif; ?>
            
          <li class="nav-item">
            <a href="salir.php" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>
                Salir      
              </p>
            </a>
          </li>        
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2 text-center">
          <div class="col-sm-6">
          <img src="dist/img/banner.png" class="img-fluid" >
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">          
            <div class="card">