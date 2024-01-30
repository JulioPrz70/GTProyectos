<?php include "includes/header.php" ?>

<?php 
  //Validar si recibimos el id, se envia por GET
  if (isset($_GET["id"])) {
    $idActividad = $_GET['id'];
  }

  //Obtener los datos por su ID
  $query ="SELECT proyectos.nombre_proyecto, actividades.nombre, actividades.descripcion, actividades.estatus, actividades.archivo FROM actividades INNER JOIN proyectos ON actividades.idproyecto = proyectos.idproyecto WHERE idactividad=:id";
  $stmt = $conn->prepare($query);
  

  //Debemos pasar a bindParam las variables, no podemos pasar el dato directamente
  //Llamado por referencia
  $stmt->bindParam(":id", $idActividad, PDO::PARAM_INT);
  $stmt->execute();

  $actividad = $stmt->fetch(PDO::FETCH_OBJ);

  //Actualizacion de la nota 
  if (isset($_POST["borrarActividad"])) {
  
    //Si entra es porque se puede borrar el registro
    $query = "DELETE FROM actividades WHERE idactividad=:idactividad"; 
    
    $stmt = $conn->prepare($query);

    $stmt->bindParam(":idactividad", $idActividad, PDO::PARAM_INT);

    $resultado = $stmt->execute();

    if ($resultado) {
      $mensaje = "Actividad borrado correctamente";
    }else{
      $error = "Error, no se pudo borrar la actividad";
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
                    <h3 class="card-title">Borrar actividad</h3>
                  </div>                 
              </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-12">
                  <form role="form" method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">            


                  <div class="mb-3">
                        <label for="idproyecto" class="form-label">Proyecto:</label>
                        <input type="text" name="idproyecto" class="form-control" value="<?php if($actividad) echo $actividad->nombre_proyecto; ?>" readonly>
                      </div>

                      <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre de la actividad:</label>
                        <textarea class="form-control" name="nombre" rows="3" readonly>
                          <?php if($actividad) echo $actividad->nombre; ?>
                        </textarea>
                      </div>     
                      
                      <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripcion:</label>
                        <textarea class="form-control" name="descripcion" rows="3" readonly>
                          <?php if($actividad) echo $actividad->descripcion; ?>
                        </textarea>
                      </div>    
                      
                      <div class="mb-3">
                        <label for="estatus" class="form-label">Estatus:</label>
                        <textarea class="form-control" name="estatus" rows="3" readonly>
                          <?php if($actividad) echo $actividad->estatus; ?>
                        </textarea>
                      </div>     

                      <div class="mb-3">
                        <label for="archivo" class="form-label">Archivo:</label>
                        <textarea class="form-control" name="archivo" rows="3" readonly>
                          <?php if($actividad) echo $actividad->archivo; ?>
                        </textarea>
                      </div>     

                            <button type="submit" name="borrarActividad" class="btn btn-primary"><i class="fas fa-cog"></i> Borrar Actividad</button>  

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