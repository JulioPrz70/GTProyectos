<?php
//Inicia la conexion
session_start();

  //Validamos si la sesion esta activa
  if (!empty($_SESSION['activo'])) {
    header("Location:panel.php");
  }

  //Incluir la base de datos
  include("conexion_sql.php");

  // Verificar si se ha enviado una solicitud POST
  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //Validar inicio de sesion
    if (isset($_POST["btningresar"])) {

      //Evalua el acceso
      if (empty($_POST["email"]) && empty($_POST["contrasena"])) {
          $error = "Error, algunos campos estan vacios";
      }else{
            //Obtenemos los valores del formulario
            $email=$_POST["email"];
            $contrasena = md5($_POST["password"]);
            
            //Consulta SQL
            $sql = "SELECT idalumno, nombre, apellidos, sexo, email, es_admin, password FROM alumnos WHERE email='$email' AND password='$contrasena'";

            //Preparar la consulta
            $resultado = $conn->query($sql);

            // Ejecutar la consulta
            $resultado->execute();

            //Obtener los resultados
            $registro = $resultado->fetch(PDO::FETCH_ASSOC);

              if (!$registro) {
                $error = "Acceso invalido";
                }else{
                    //Creamos sesiones
                  $_SESSION['activo'] = true;
                  $_SESSION['idAlumno'] = $registro['idalumno'];
                  $_SESSION['nombre'] = $registro['nombre'];
                  $_SESSION['apellidos'] = $registro['apellidos'];
                  $_SESSION['email'] = $registro['email'];
                  $_SESSION['esAdmin'] = $registro['es_admin'];
                  $_SESSION['sexo'] = $registro['sexo'];

                  //Redireccion al panel.php
                  header("Location:panel.php");
                }
            }

    }
}


?>

<!doctype html>
<html lang="es">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
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
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
  
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    
    <link rel="icon" href="dist/img/tecnm.jpg" type="opacity: .8">
    <link rel="shortcut icon" href="dist/img/tecnm.jpg" type="opacity: .8">

    <title>Login Proyectos GT</title>
  </head>
  <body class="hold-transition login-page">

  <div class="row">
    <div class="col-sm-12">
      <?php if(isset($error)) : ?>
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <strong><?php echo $error; ?></strong> 
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
        <?php endif;?>
    </div>
  </div>


  <div class="login-box">
  <div class="login-logo">
    <img src="dist/img/account.png" class="img-fluid mt-2" width="200">
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg"><b>Iniciar sesión</b></p>

      <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
        <div class="input-group mb-3">
          <input type="email" class="form-control" name="email" placeholder="Ingrese su correo" require>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" placeholder="Ingrese la contraseña" require>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          
          <!-- /.col -->
          <div class="col-sm-12">
            <button type="submit" name="btningresar" class="btn btn-primary d-block w-100"><i class="fas fa-user"></i>&nbsp; Ingresar</button>
          </div>
          <!-- /.col -->
        </div>
        <p class="btn btn-secondary d-block w-100 mt-2"><a href="alta_usuario.php" class="text-light "><i class="fas fa-user-plus"></i>&nbsp; Registrarse</a></p>
      </form>  
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- REQUIRED SCRIPTS -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- date-range-picker -->
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>

</body>
</html>