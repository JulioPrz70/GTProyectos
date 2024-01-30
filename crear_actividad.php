<?php include "includes/header.php" ?>

<?php
  if (isset($_POST["registrarActividad"])) {
    if (isset($_FILES['archivo'])) {
      extract($_POST);
      //Obtener valores
      $idproyecto = $_POST['idproyecto'];
      $nombre = $_POST['nombre'];
      $descripcion = $_POST['descripcion'];
      $estatus = $_POST['estatus'];
  
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
            $query = "INSERT INTO actividades(idproyecto, nombre, descripcion, estatus, archivo)
            VALUES (:idproyecto, :nombre, :descripcion, :estatus, :archivo)";
  
  
            $stmt = $conn->prepare($query);
  
            $stmt->bindParam(":idproyecto", $idproyecto, PDO::PARAM_INT);
            $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
            $stmt->bindParam(":descripcion", $descripcion, PDO::PARAM_STR);
            $stmt->bindParam(":estatus", $estatus, PDO::PARAM_STR);
            $stmt->bindParam(":archivo", $nombre_archivo, PDO::PARAM_STR);
  
            $resultado = $stmt->execute();
  
            if ($resultado) {
              $mensaje = "Actividad creado correctamente";
            }else{
              $error = "Error, no se pudo crear la actividad";
            }
          }
      } else{$error = "Solo se permiten archivos PDF, DOC y DOCX.";}
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
                    <h3 class="card-title">Nueva actividad</h3>
                  </div>                 
              </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-12">
                  <form role="form" method="POST" action="<?php $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">            
                      
                        <?php
                        try {
                          $query = "SELECT * FROM proyectos WHERE idalumno='$idAlumno'";
                            $statement = $conn->prepare($query);
                            $statement->execute();
                        
                            echo "<label for='idproyecto' class='form-label'>Proyecto:</label>
                            <select  class='form-control mb-3' name='idproyecto' aria-label='Default select example' >";
                            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                                echo "<option value='{$row['idproyecto']}'>{$row['nombre_proyecto']}</option>";
                            }
                            echo "</select>";
                        } catch (PDOException $e) {
                            die("Error al ejecutar la consulta: " . $e->getMessage());
                        }
                        ?>

                      <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre de la actividad:</label>
                        <input type="text" name="nombre" class="form-control" required>
                      </div>     
                      
                      <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción:</label>
                        <textarea class="form-control" name="descripcion" required>
                        </textarea>
                      </div>    
                      
                      <div class="mb-3">
                        <label for="estatus" class="form-label">Estatus:</label>
                        <input type="text" name="estatus" class="form-control" value="Enviado" readonly>
                      </div>     

                      <div class="mb-3">
                        <label for="archivo" class="form-label">Archivo:</label>
                        <input type="file" name="archivo" id="archivo" class="form-control" required>
                      </div>     
                    
                          <button type="submit" name="registrarActividad" class="btn btn-primary"><i class="fas fa-cog"></i> Crear Proyecto</button>  

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
