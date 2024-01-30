<?php include "includes/header.php" ?>

<?php 
  //Validar si recibimos el id, se envia por GET
  if (isset($_GET["id"])) {
    $idActividad = $_GET['id'];
  }

  //Obtener los datos de la nota por su ID
  $query ="SELECT proyectos.nombre_proyecto, actividades.nombre, actividades.descripcion, actividades.estatus, actividades.archivo FROM actividades INNER JOIN proyectos ON actividades.idproyecto = proyectos.idproyecto WHERE idactividad=:id";
  $stmt = $conn->prepare($query);
  

  //Debemos pasar a bindParam las variables, no podemos pasar el dato directamente
  //Llamado por referencia
  $stmt->bindParam(":id", $idActividad, PDO::PARAM_INT);
  $stmt->execute();

  $actividad = $stmt->fetch(PDO::FETCH_OBJ);
  
  //Actualizacion 
  if (isset($_POST["editarActividad"])) {
    if (isset($_FILES['archivo'])) {
      extract($_POST);

    //Obtener valores
    $nombre = trim($_POST["nombre"]);
    $descripcion = trim($_POST["descripcion"]);
    $estatus = trim($_POST["estatus"]);
  

    //Validar si esta vacio
    if (empty($nombre) || empty($descripcion) || empty($estatus)) {
      $error = "Error, algunos campos obligatorios están vacios";
    }else{
            //Definir carpeta de destino
            $carpeta_destino = "dist/files/";

            //Obtener el nombre y extension del archivo
            $nombre_archivo = basename($_FILES["archivo"]["name"]);
            $extension = strtolower(pathinfo($nombre_archivo, PATHINFO_EXTENSION));
        
            //Validar la extension del archivo
            if ($extension == "pdf" || $extension == "doc" || $extension == "docx") {
                //Mover el archivo a la carpeta de destino
                if (move_uploaded_file($_FILES["archivo"]["tmp_name"], $carpeta_destino . $nombre_archivo)) {
                    //Insertar información a la Base de datos

                //Si entra es porque se puede ingresar un nuevo registro
                $query = "UPDATE actividades SET nombre=:nombre, 
                descripcion=:descripcion, estatus=:estatus, archivo=:archivo  WHERE idactividad=:idactividad"; 
              
                $stmt = $conn->prepare($query);

                $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
                $stmt->bindParam(":descripcion", $descripcion, PDO::PARAM_STR);
                $stmt->bindParam(":estatus", $estatus, PDO::PARAM_STR);
                $stmt->bindParam(":archivo", $nombre_archivo, PDO::PARAM_STR);
                $stmt->bindParam(":idactividad", $idActividad, PDO::PARAM_INT);
                

                $resultado = $stmt->execute();

                  if ($resultado) {
                    $mensaje = "Registro de actividad editado correctamente";
                  }else{
                    $error = "Error, no se pudo editar la actividad";
                  }
              } 
            }else{$error = "Solo se permiten archivos PDF, DOC y DOCX.";}
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
                          <input type="text" name="estatus" class="form-control" name="estatus" value="Enviado"  style="display:none" readonly>
                          <?php if($actividad) echo $actividad->estatus;?>
                        </input>
                      </div>     
                      
                      <div class="mb-3">
                        <label for="archivo" class="form-label">Archivo:</label>
                        <input type="file" name="archivo" id="archivo" class="form-control" required>
                      </div>     
                            <button type="submit" name="editarActividad" class="btn btn-primary"><i class="fas fa-cog"></i> Editar Actividad</button>  
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
