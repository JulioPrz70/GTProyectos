<?php include "includes/header.php" ?>

<?php 
  //Validar si recibimos el id, se envia por GET
  if (isset($_GET["id"])) {
    $idProyecto = $_GET['id'];
  }

  //Obtener los datos de la nota por su ID
  $query ="SELECT * FROM proyectos WHERE idproyecto=:id";
  $stmt = $conn->prepare($query);
  

  //Debemos pasar a bindParam las variables, no podemos pasar el dato directamente
  //Llamado por referencia
  $stmt->bindParam(":id", $idProyecto, PDO::PARAM_INT);
  $stmt->execute();

  $proyecto = $stmt->fetch(PDO::FETCH_OBJ);

  //Actualizacion de la nota 
  if (isset($_POST["borrarProyecto"])) {
  
    //Si entra es porque se puede borrar el registro
    $query = "DELETE FROM proyectos WHERE idproyecto=:idproyecto"; 
    
    $stmt = $conn->prepare($query);

    $stmt->bindParam(":idproyecto", $idProyecto, PDO::PARAM_INT);

    $resultado = $stmt->execute();

    if ($resultado) {
      $mensaje = "Proyecto borrado correctamente";
    }else{
      $error = "Error, no se pudo borrar el proyecto";
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
                    <h3 class="card-title">Borrar proyecto</h3>
                  </div>                 
              </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-12">
                  <form role="form" method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">            


                      <div class="mb-3">
                        <label for="nombre_proyecto" class="form-label">Proyecto:</label>
                        <input type="text" name="nombre_proyecto" class="form-control" value="<?php if($proyecto) echo $proyecto->nombre_proyecto; ?>" readonly>
                      </div>

                      <div class="mb-3">
                        <label for="concepto_negocio" class="form-label">Concepto de Negocio:</label>
                        <textarea class="form-control" name="concepto_negocio" rows="3" readonly>
                          <?php if($proyecto) echo $proyecto->concepto_negocio; ?>
                        </textarea>
                      </div>     
                      
                      <div class="mb-3">
                        <label for="metas" class="form-label">Metas:</label>
                        <textarea class="form-control" name="metas" rows="3" readonly>
                          <?php if($proyecto) echo $proyecto->metas; ?>
                        </textarea>
                      </div>    
                      
                      <div class="mb-3">
                        <label for="valores" class="form-label">Valores:</label>
                        <textarea class="form-control" name="valores" rows="3" readonly>
                          <?php if($proyecto) echo $proyecto->valores; ?>
                        </textarea>
                      </div>     

                      <div class="mb-3">
                        <label for="retos" class="form-label">Retos:</label>
                        <textarea class="form-control" name="retos" rows="3" readonly>
                          <?php if($proyecto) echo $proyecto->retos; ?>
                        </textarea>
                      </div>     

                      <div class="mb-3">
                        <label for="dolores" class="form-label">Dolores:</label>
                        <textarea class="form-control" name="dolores" rows="3" readonly>
                          <?php if($proyecto) echo $proyecto->dolores; ?>
                        </textarea>
                      </div>     
                      
                      <div class="mb-3">
                        <label for="comunidad" class="form-label">Comunidad:</label>
                        <input type="text" name="comunidad" class="form-control" value="<?php if($proyecto) echo $proyecto->comunidad; ?>" readonly>
                      </div>

                      <div class="mb-3">
                        <label for="colaboradores" class="form-label">Colaboradores:</label>
                        <textarea class="form-control" name="colaboradores" rows="3" readonly>
                          <?php if($proyecto) echo $proyecto->colaboradores; ?>
                        </textarea>
                      </div>       

                            <button type="submit" name="borrarProyecto" class="btn btn-primary"><i class="fas fa-cog"></i> Borrar Proyecto</button>  

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
