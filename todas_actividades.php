<?php 
    //Validamos si esta logueado
    if (isset($_SESSION['activo']) && $_SESSION['esAdmin'] == 1) {
        header("Location:panel.php");
    }

    include "includes/header.php";

    //Mostrar registros
    $query = "SELECT * FROM actividades INNER JOIN proyectos ON actividades.idproyecto = proyectos.idproyecto ORDER BY estatus='Enviado' DESC, estatus='Aceptado' ASC";
    $stmt = $conn->query($query);
    $registros = $stmt->fetchAll(PDO::FETCH_OBJ);
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
                  <div class="col-md-9 mt-3 mb-3">
                    <h3 class="card-title">Actividades</h3>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
            

                <table id="tblRegistros" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th><b>Id</b></th>
                    <th><b>Nombre</b></th>               
                    <th><b>Descripción</b></th>
                    <th><b>Proyecto</b></th>
                    <th><b>Archivo</b></th>
                    <th><b>Estatus</b></th>
                  </tr>
                  </thead>
                  <tbody>
                 
                  <?php foreach($registros as $fila) : ?>
                      <tr class="text-center">
                          <td><?php echo $fila->idactividad; ?></td>
                          <td><?php echo $fila->nombre; ?></td>
                          <td><?php echo $fila->descripcion; ?></td>
                          <td><?php echo $fila->nombre_proyecto; ?></td> 
                          <td>
                            <a href="descargar_archivo.php?id=<?php echo $fila->idactividad; ?>" class="btn btn-light">
                            <i class="fas fa-download"></i>&nbsp;<?php echo $fila->archivo; ?></a>
                          </td>  
                          <td class="text-bold">
                          <?php if(isset($_SESSION['activo']) && $_SESSION['esAdmin'] == 1) :
                            echo $fila->estatus;?>
                                <br>  
                                <a href="validar_actividad.php?id=<?php echo $fila->idactividad; ?>" class="btn btn-warning"><i class="bi bi-pencil-fill"></i> <i class="fas fa-search"></i> Revisar</a>
                            <?php endif?> 
                          </td>         
                      </tr>
                  <?php endforeach; ?>
                  </tbody>                  
                </table>
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
      "ordering": false,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    }); 
  });
</script>
