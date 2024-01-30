<?php include "includes/header.php" ?>

<?php
//Mostrar registros
$query = "SELECT * FROM actividades INNER JOIN proyectos ON actividades.idproyecto = proyectos.idproyecto WHERE proyectos.idalumno = $idAlumno";
$stmt = $conn->query($query);
$registros = $stmt->fetchAll(PDO::FETCH_OBJ);
?>

              <div class="card-header">               
                <div class="row">
                  <div class="col-md-9 mt-3 mb-3">
                    <h3 class="card-title">Lista de Actividades</h3>
                  </div>
                </div>
                  <div class="col-lg-2 text-center mt-3 mb-3" >
                    <?php if(isset($_SESSION['activo']) && $_SESSION['esAdmin'] == 0) : ?>
                      <a href="crear_actividad.php" type="button" class="btn btn-primary btn-xl pull-right w-100">
                        <i class="fa fa-plus"></i> Nueva Actividad
                      </a>
                    <?php endif; ?> 
                  </div>

              <!-- /.card-header -->
              <div class="card-body">
                <table id="tblRegistros" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th><b>Id</b></th>
                    <th><b>Nombre</b></th>
                    <th><b>Descripción</b></th>
                    <th><b>Proyecto vinculado</b></th>
                    <th><b>Estatus</b></th>
                    <th><b>Archivo</b></th>
                    <th><b>Acciones</b></th>
                  </tr>
                  </thead>
                  <tbody> 
                  <?php foreach($registros as $fila) : ?>
                      <tr>
                          <td><?php echo $fila->idactividad; ?></td>
                          <td><?php echo $fila->nombre; ?></td>
                          <td><?php echo $fila->descripcion; ?></td>
                          <td><?php echo $fila->nombre_proyecto; ?></td>
                          <td><?php echo $fila->estatus; ?></td>
                          <td>
                            <a href="descargar_archivo.php?id=<?php echo $fila->idactividad; ?>" class="btn btn-light">
                            <i class="fas fa-download"></i>&nbsp;<?php echo $fila->archivo; ?></a>
                          </td> 
                          <td>
                          <?php if(isset($_SESSION['activo']) && $_SESSION['esAdmin'] == 0) : ?>
                                <a href="editar_actividad.php?id=<?php echo $fila->idactividad; ?>" class="btn btn-warning"><i class="bi bi-pencil-fill"></i> <i class="fas fa-edit"></i> Editar</a>
                                &nbsp;
                                <a href="borrar_actividad.php?id=<?php echo $fila->idactividad; ?>" class="btn btn-danger"><i class="bi bi-pencil-fill"></i> <i class="fas fa-trash-alt"></i> Borrar</a>                                               
                            <?php endif?>
                            <?php if(isset($_SESSION['activo']) && $_SESSION['esAdmin'] == 1) : ?>
                              <a>No disponible.</a>
                              <?php endif; ?>   
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
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    }); 
  });
</script>
