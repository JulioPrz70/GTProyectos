<?php include "includes/header.php" ?>

<?php 
  //Validar si recibimos el id, se envia por GET
  if (isset($_GET["id"])) {
    $idActividad = $_GET['id'];
  }

  //Obtener los datos de la nota por su ID
  $query ="SELECT proyectos.nombre_proyecto, actividades.nombre, actividades.descripcion, actividades.estatus FROM actividades INNER JOIN proyectos ON actividades.idproyecto = proyectos.idproyecto WHERE idactividad=:id";
  $stmt = $conn->prepare($query);
  

  //Debemos pasar a bindParam las variables, no podemos pasar el dato directamente
  //Llamado por referencia
  $stmt->bindParam(":id", $idActividad, PDO::PARAM_INT);
  $stmt->execute();

  $actividad = $stmt->fetch(PDO::FETCH_OBJ);
  
  //Actualizacion 
  if (isset($_POST["validarActividad"])) {

    //Obtener valores
    $nombre = trim($_POST["nombre"]);
    $descripcion = trim($_POST["descripcion"]);
    $estatus = trim($_POST["estatus"]);
  

    //Validar si esta vacio
    if (empty($nombre) || empty($descripcion) || empty($estatus)) {
      $error = "Error, algunos campos obligatorios están vacios";
    }else{
                //Si entra es porque se puede ingresar un nuevo registro
                $query = "UPDATE actividades SET nombre=:nombre, 
                descripcion=:descripcion, estatus=:estatus WHERE idactividad=:idactividad"; 
              
                $stmt = $conn->prepare($query);

                $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
                $stmt->bindParam(":descripcion", $descripcion, PDO::PARAM_STR);
                $stmt->bindParam(":estatus", $estatus, PDO::PARAM_STR);
                $stmt->bindParam(":idactividad", $idActividad, PDO::PARAM_INT);
                

                $resultado = $stmt->execute();

                  if ($resultado) {
                    $mensaje = "Calificado correctamente";
                  }else{
                    $error = "Error, no se pudo calificar la actividad";
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
                    <h3 class="card-title">Editar Actividad</h3>
                  </div>                 
              </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-12">
                  <form role="form" method="POST" action="<?php $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">            

                      <div class="mb-3">
                        <label for="idproyecto" class="form-label">Proyecto:</label>
                        <input type="text" name="idproyecto" class="form-control" value="<?php if($actividad) echo $actividad->nombre_proyecto; ?>" readonly>
                      </div>
                      
                      <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre de la actividad:</label>
                        <input type="text" name="nombre" class="form-control" value="<?php if($actividad) echo $actividad->nombre; ?>">
                      </div>     
                      
                      <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripcion:</label>
                        <textarea class="form-control" name="descripcion">
                          <?php if($actividad) echo $actividad->descripcion; ?>
                        </textarea>
                      </div>    
                      
                      <div class="mb-3">
                        <label for="estatus" class="form-label">Estatus:</label>
                             
                              <label for="estatus" class="form-label"></label>
                              <select class="form-control" name="estatus" aria-label="Default select example">
                                <option value=""><?php echo $actividad->estatus; ?></option>
                                <?php
                                if ($actividad->estatus == "Enviado") {
                                  echo '<option value="Aceptado">Aceptar</option>';
                                  echo '<option value="Rechazado">Rechazar</option>';
                                } else {
                                  if ($actividad->estatus == "Aceptado") {
                                    echo '<option value="Rechazado">Rechazar</option>';
                                  }else{
                                    if ($actividad->estatus == "Rechazado") {
                                      echo '<option value="Aceptado">Aceptar</option>';
                                    }else{
                                    echo '<option value="">Selecciona una opción</option>';
                                    echo '<option value="Aceptado">Aceptar</option>';
                                  echo '<option value="Rechazado">Rechazar</option>';
                                    }
                                  }
                                }
                                ?>
                              </select>  
                          </div>
                          <button type="submit" name="validarActividad" class="btn btn-primary"><i class="fas fa-cog"></i> Calificar Actividad</button>  
                      </div>   
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
