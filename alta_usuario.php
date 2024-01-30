<?php //Dar de alta a un usuario nuevo

//Incluir la conexion
include_once("conexion_sql.php");


if (isset($_POST["crearUsuario"])) {
    
  //Obtener valores
  $nombre = $_POST["nombre"];
  $apellidos = $_POST["apellidos"];
  $edad = $_POST["edad"];
  $sexo = $_POST["sexo"];
  $carrera = $_POST["carrera"];
  $email = $_POST["email"];
  $password = md5($_POST["password"]);
  $rol = $_POST["rol"];
  
  //Validar si esta vacio
  if (empty($nombre) || empty($apellidos) || empty($edad) || empty($sexo) || empty($carrera) || empty($email) || empty($password)) {
    $error = "Error, algunos campos obligatorios están vacios.";
  }else{
    $query = "SELECT * FROM alumnos WHERE password = '$password' OR email = '$email'";
    $resultado = $conn->query($query);

    //Ejecutar la consulta
    $resultado->execute();

    //Obtener los resultados
    $registro = $resultado->fetch(PDO::FETCH_ASSOC);

    if ($registro) {
       $error = "Los datos ingresados ya se encuentra en el sistema.";
      }else{
          //Si entra es porque se puede ingresar un nuevo registro
          $query = "INSERT INTO alumnos(nombre, apellidos, edad, sexo, carrera, email, password, es_admin)
          VALUES (:nombre, :apellidos, :edad, :sexo, :carrera, :email, :password, :es_admin)";

          $stmt = $conn->prepare($query);

          $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
          $stmt->bindParam(":apellidos", $apellidos, PDO::PARAM_STR);
          $stmt->bindParam(":edad", $edad, PDO::PARAM_INT);
          $stmt->bindParam(":sexo", $sexo, PDO::PARAM_STR);
          $stmt->bindParam(":carrera", $carrera, PDO::PARAM_STR);
          $stmt->bindParam(":email", $email, PDO::PARAM_STR);
          $stmt->bindParam(":password", $password, PDO::PARAM_STR);
          $stmt->bindParam(":es_admin", $rol, PDO::PARAM_INT);

          $resultado = $stmt->execute();

          if ($resultado) {
            $result = "";
            if (isset($_POST['crearUsuario'])) {
              //Configuración del servidor
              require 'phpmailer/PHPMailerAutoload.php';
              $mail = new PHPMailer;
              $mail->isSMTP();
              $mail->Host='smtp.gmail.com';
              $mail->Port=587;
              $mail->SMTPAuth=true;
              $mail->SMTPSecure='tls';
              $mail->Username='akatskihuchiah@gmail.com';
              $mail->Password='fuqw zyyv idqf uwwg';

              //Configuración del destinatario
              /*
              $mail->setFrom($_POST['email'], $_POST['nombre']);
              $mail->addAddress('akatskihuchiah@gmail.com');
              $mail->addReplyTo($_POST['email'], $_POST['nombre']);

              $mail->isHTML(true);
              $mail->Subject='Enviado por '.$_POST['nombre'];
              $mail->Body='<h1 align=center> Nombre: '.$_POST['nombre'].'<br>Email: '.$_POST['email'].'<br>Mensaje: Bienvenido al sistema </h1>';
              */

              //Configuración del destinatario
              $mail->setFrom('daniel.pg@hopelchen.tecnm.mx', 'Sistema de Proyectos GT');
              $mail->addAddress($_POST['email']);
              $mail->addAddress('akatskihuchiah@gmail.com');
              $mail->addReplyTo('daniel.pg@hopelchen.tecnm.mx', 'Daniel Alberto Panti Gonzales');

              $mail->isHTML(true);
              $mail->Subject='Registro al sistema';
              $mail->Body='
              <html>
                <body style="text-align: center; padding: 30px;">
                <h1 style="color: secondary; padding-top: 5px;">¡Bienvenido!</h1>
                <h1 class="pb-4"><br>Hola '.$_POST['nombre'].' '.$_POST['apellidos'].', 👋<br>Hemos registrado tu correo: '.$_POST['email'].'<br><br>Comienza a registrar tus proyectos 📄😄<br></h1>
                <button> <a style="color:black" href="https://proyectokelloggt.rf.gd/" role="button"><b>Iniciar sesión</b></a> </button>
                <h5 style="padding: 25px;"><b>Estamos para servirte,</b> <br>
                    Tu equipo de Proyectos GT.
                </h5>            
                </body>
              </html>
              ';
              if (!$mail->send()) {
                $result= "Algo salió mal, inténtelo de nuevo.";
              }else{
                $result= '<br>Le hemos enviado un correo de confirmación, revise su bandeja de entrada o SPAM.';
              }

            }
            $mensaje = "Registro Exitoso. ";
          }else{
            $error = "Error, no se pudo crear el usuario.";
          }
      }
  }

}
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
  
</head>
<scrip class="hold-transition sidebar-mini">
<div class="">

<body>

  <div class="container">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <img src="dist/img/banner.png" class="img-fluid" >
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>


    <!-- Main content -->
    <section class="content">
    
      <div class="row">
         <div class="col-sm-12">
          <?php if(isset($mensaje)) : ?>
                  <div class="alert alert-success alert-dismissible fade show" role="alert">
                      <strong><?php echo $mensaje; ?> <a href="index.php">Iniciar sesión</a> </strong> 
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
            <?php endif;?>
          </div>
      </div>

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

      
      <div style="width: 90%; height: 100%;" class="login-box container-fluid mt-2 pb-3 mb-3 ">
        <div class="row">
          <div class="col-12">          
            <div class="card">
              <div class="card-header">               
                <div class="row">
                  <div class="col-md-9">
                    <h3 class="card-title">Crear un nuevo usuario</h3>
                  </div>                 
              </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-12">
                  <form role="form" method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">            

                      <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre:</label>
                        <input type="text" name="nombre" class="form-control">
                      </div>

                      <div class="mb-3">
                        <label for="apellidos" class="form-label">Apellidos:</label>
                        <input type="text" name="apellidos" class="form-control">
                      </div>

                      <div class="mb-3">
                        <label for="edad" class="form-label">Edad:</label>
                        <input type="text" name="edad" class="form-control">
                      </div>

                      <div class="mb-3">
                       <label for="sexo" class="form-label">Sexo:</label>
                        <select class="form-control" name="sexo" aria-label="Default select example">
                        <option value="">Selecciona una opción</option>
                        <option value="H">Hombre</option>
                        <option value="M">Mujer</option>
                        </select>  
                      </div>

                      <div class="mb-3">
                       <label for="carrera" class="form-label">Carrera:</label>
                        <select class="form-control" name="carrera" aria-label="Default select example">
                        <option value="">Selecciona una opción</option>
                        <option value="Licenciatura en Administración de Empresas">Licenciatura en Administración de Empresas</option>
                        <option value="Ingeniería en Sistemas Computacionales">Ingeniería en Sistemas Computacionales</option>
                        <option value="Ingeniería en Innovación Agrícola Sustentable">Ingeniería en Innovación Agrícola Sustentable</option>
                        </select>  
                      </div>
                      
                      <div class="mb-3">
                        <label for="email" class="form-label">Correo:</label>
                        <input id="email" type="email" name="email" class="form-control">
                      </div>    

                       <div class="mb-3">
                        <label for="password" class="form-label">Contraseña:</label>
                        <input type="password" name="password" class="form-control">
                      </div>   

                      <div class="mb-3">
                       <label for="rol" class="form-label">Rol:</label>
                        <select class="form-control" name="rol" aria-label="Disabled select example" disable> 
                        <option value="0" >Consultor</option>
                        </select>  
                      </div>   

                            <button type="submit" name="crearUsuario" class="btn btn-success mt-3"><i class="fas fa-cog"></i> Registrarse</button>  
                            <br>
                            <h5 class="notifCorrecto"><?= $result;?></h5>
                        </div>
                      </form>
                  </div>
                </div>
              </div>
              <!-- /.card-body -->
  </body>
</html>

<?php include "includes/footer.php" ?>

<!-- page script -->
<script>
  $(function () {   
    $('#tblRegistros').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    }); 
  });
</script>