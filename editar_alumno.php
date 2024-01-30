<?php include "includes/header.php" ?>

<?php 
  //Validar si recibimos el id, se envia por GET
  if (isset($_GET["id"])) {
    $idalumno = $_GET['id'];
  }

  //Obtener los datos del alumno por el ID
  $query ="SELECT * FROM alumnos WHERE idalumno=:id";
  $stmt = $conn->prepare($query);
  

  //Debemos pasar a bindParam las variables, no podemos pasar el dato directamente
  //Llamado por referencia
  $stmt->bindParam(":id", $idalumno, PDO::PARAM_INT);
  $stmt->execute();

  $alumno = $stmt->fetch(PDO::FETCH_OBJ);
  
  //Actualizacion datos
  if (isset($_POST["editarPerfil"])) {
    
    //Obtener valores
    $nombre = $_POST["nombre"];
    $apellidos = $_POST["apellidos"];
    $edad = $_POST["edad"];
    $sexo = $_POST["sexo"];
    $carrera = $_POST["carrera"];
    $email = $_POST["email"];
    $contrasena = $_POST["password"];
    $password = md5($contrasena);
    $rol = $_POST["rol"];


    //Validar si esta vacio
    if (empty($nombre) || empty($apellidos) || empty($edad) ||
    empty($email) || empty($contrasena)) {
      $error = "Error, algunos campos obligatorios están vacios.";
    }else{
      //Si entra es porque se puede ingresar un nuevo registro
      $query = "UPDATE alumnos SET nombre=:nombre, apellidos=:apellidos, edad=:edad, 
      sexo=:sexo, carrera=:carrera, email=:email, password=:password, es_admin=:es_admin  WHERE idalumno=:idalumno"; 
    
      $stmt = $conn->prepare($query);

      $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
      $stmt->bindParam(":apellidos", $apellidos, PDO::PARAM_STR);
      $stmt->bindParam(":edad", $edad, PDO::PARAM_INT);
      $stmt->bindParam(":sexo", $sexo, PDO::PARAM_STR);
      $stmt->bindParam(":carrera", $carrera, PDO::PARAM_STR);
      $stmt->bindParam(":email", $email, PDO::PARAM_STR);
      $stmt->bindParam(":password", $password, PDO::PARAM_STR);
      $stmt->bindParam(":es_admin", $rol, PDO::PARAM_INT);
      $stmt->bindParam(":es_admin", $rol, PDO::PARAM_INT);
      $stmt->bindParam(":idalumno", $idalumno, PDO::PARAM_INT);
      

      $resultado = $stmt->execute();

      if ($resultado) {
        $mensaje = "Datos actualizados";
      }else{
        $error = "Error, no se pudo actualizar los datos";
      }
    }
  }
?>

<div class="row">
    <div class="col-sm-12">
    <?php if(isset($mensaje)) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong><?php echo $mensaje; ?></strong> 
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

              <div class="card-header">               
                <div class="row">
                  <div class="col-md-9">
                  <?php  
                  echo '<h3 class="card-title text-bold">Modificar perfil de '.$alumno->nombre." ".$alumno->apellidos.'</h3>';
                  ?>
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
                        <input type="text" name="nombre" class="form-control" value="<?php if($alumno) echo $alumno->nombre; ?>">
                      </div>

                      <div class="mb-3">
                        <label for="apellidos" class="form-label">Apellidos:</label>
                        <input type="text" name="apellidos" class="form-control" value="<?php if($alumno) echo $alumno->apellidos; ?>">
                      </div>

                      <div class="mb-3">
                        <label for="edad" class="form-label">Edad:</label>
                        <input type="text" name="edad" class="form-control" value="<?php if($alumno) echo $alumno->edad; ?>">
                      </div>

                      <div class="mb-3">
                       <label for="sexo" class="form-label">Sexo:</label>
                        <select class="form-control" name="sexo" aria-label="Default select example">
                        <?php
                          if ($alumno->sexo == "H") {
                            echo '<option value="H">Hombre</option>';
                            echo '<option value="M">Mujer</option>';
                          } else {
                            if ($alumno->sexo == "M") {
                              echo '<option value="M">Mujer</option>';
                              echo '<option value="H">Hombre</option>';
                            }else{
                              echo '<option value="">Selecciona una opción</option>';
                              echo '<option value="H">Hombre</option>';
                              echo '<option value="M">Mujer</option>';
                            }
                          }
                        ?>
                        </select>  
                      </div>

                      <div class="mb-3">
                       <label for="carrera" class="form-label">Carrera:</label>
                        <select class="form-control" name="carrera" aria-label="Default select example">
                        <?php
                          if ($alumno->carrera == "Licenciatura en Administración de Empresas") {
                            echo '<option value="Licenciatura en Administración de Empresas">Licenciatura en Administración de Empresas</option>';
                            echo '<option value="Ingeniería en Sistemas Computacionales">Ingeniería en Sistemas Computacionales</option>';
                            echo '<option value="Ingeniería en Innovación Agrícola Sustentable">Ingeniería en Innovación Agrícola Sustentable</option>';
                          } else {
                            if ($alumno->carrera == "Ingeniería en Sistemas Computacionales") {
                              echo '<option value="Ingeniería en Sistemas Computacionales">Ingeniería en Sistemas Computacionales</option>';
                              echo '<option value="Licenciatura en Administración de Empresas">Licenciatura en Administración de Empresas</option>';
                              echo '<option value="Ingeniería en Innovación Agrícola Sustentable">Ingeniería en Innovación Agrícola Sustentable</option>';
                            }else{
                              if ($alumno->carrera == "Ingeniería en Innovación Agrícola Sustentable") {
                                echo '<option value="Ingeniería en Innovación Agrícola Sustentable">Ingeniería en Innovación Agrícola Sustentable</option>';
                                echo '<option value="Ingeniería en Sistemas Computacionales">Ingeniería en Sistemas Computacionales</option>';
                                echo '<option value="Licenciatura en Administración de Empresas">Licenciatura en Administración de Empresas</option>';
                              }else{
                                echo '<option value="">Selecciona una opción</option>';
                                echo '<option value="Licenciatura en Administración de Empresas">Licenciatura en Administración de Empresas</option>';
                                echo '<option value="Ingeniería en Sistemas Computacionales">Ingeniería en Sistemas Computacionales</option>';
                                echo '<option value="Ingeniería en Innovación Agrícola Sustentable">Ingeniería en Innovación Agrícola Sustentable</option>';
                              }
                            }
                          }
                        ?>
                        </select>  
                      </div>
                      
                      <div class="mb-3">
                        <label for="email" class="form-label">Correo:</label>
                        <input type="email" name="email" class="form-control" value="<?php if($alumno) echo $alumno->email; ?>">
                      </div>    

                       <div class="mb-3">
                        <label for="password" class="form-label">Contraseña actual:</label>
                        <input type="password" name="password" class="form-control">
                      </div>   

                      <div class="mb-3">
                       <label for="rol" class="form-label">Rol:</label>
                        <select class="form-control" name="rol" aria-label="Disabled select example" disable value=""> 
                        <?php
                          if ($alumno->es_admin == "0") {
                            echo '<option value="0">Consultor</option>';
                            echo '<option value="1">Administrador</option>';
                          } else {
                            if ($alumno->es_admin == "1") {
                              echo '<option value="1">Administrador</option>';
                              echo '<option value="0">Consultor</option>';
                            }
                          }
                        ?>
                        </select>  
                      </div>   

                            <button type="submit" name="editarPerfil" class="btn btn-primary"><i class="fas fa-cog"></i> Guardar cambios</button>  

                        </div>
                      </form>
                  </div>
                </div>
              </div>
              <!-- /.card-body -->


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
