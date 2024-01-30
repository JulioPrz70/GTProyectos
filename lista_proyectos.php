<?php include "includes/header.php" ?>

<?php 

//Validar si recibimos el id, se envia por GET

if (isset($_GET["id"])) {
  $idAlumno = $_GET['id'];
}

    //Mostrar registros
    $query = "SELECT * FROM proyectos WHERE idalumno='$idAlumno'";
    $stmt = $conn->query($query);
    $registros = $stmt->fetchAll(PDO::FETCH_OBJ);

//var_dump($registros);

?>

              <div class="card-header">               
                <div class="row">
                  <div class="col-md-9 mt-3 mb-3">
                    <h3 class="card-title">Lista de Proyectos</h3>
                  </div>
                </div>
                  <div class="col-lg-2 text-center mt-3 mb-3" style="display: flex; justify-content: center; position: relative; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                    
                    <a href="reportesest.php?id=<?php echo $idAlumno; ?>" type="button" class="btn btn-primary btn-xl pull-right w-100">
                      <svg xmlns="http://www.w3.org/2000/svg" height="25" width="25" viewBox="0 0 384 512"><!--!Font Awesome Free 6.5.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path fill="#ffffff" d="M320 464c8.8 0 16-7.2 16-16V160H256c-17.7 0-32-14.3-32-32V48H64c-8.8 0-16 7.2-16 16V448c0 8.8 7.2 16 16 16H320zM0 64C0 28.7 28.7 0 64 0H229.5c17 0 33.3 6.7 45.3 18.7l90.5 90.5c12 12 18.7 28.3 18.7 45.3V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V64z"/></svg>
                        Descargar
                    </a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    
                    <a href="reportexlsest.php?id=<?php echo $idAlumno ?>" type="button" class="btn btn-success btn-xl pull-right w-100">
                      <svg xmlns="http://www.w3.org/2000/svg" height="25" width="25" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path fill="#ffffff" d="M128 464H64c-8.8 0-16-7.2-16-16V64c0-8.8 7.2-16 16-16H224v80c0 17.7 14.3 32 32 32h80V288h48V154.5c0-17-6.7-33.3-18.7-45.3L274.7 18.7C262.7 6.7 246.5 0 229.5 0H64C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64h64V464zm96-96c0-8.8-7.2-16-16-16s-16 7.2-16 16c0 13.6 4 26.9 11.6 38.2L220.8 432l-17.2 25.8C196 469.1 192 482.4 192 496c0 8.8 7.2 16 16 16s16-7.2 16-16c0-7.3 2.2-14.4 6.2-20.4l9.8-14.7 9.8 14.7c4 6.1 6.2 13.2 6.2 20.4c0 8.8 7.2 16 16 16s16-7.2 16-16c0-13.6-4-26.9-11.6-38.2L259.2 432l17.2-25.8C284 394.9 288 381.6 288 368c0-8.8-7.2-16-16-16s-16 7.2-16 16c0 7.3-2.2 14.4-6.2 20.4L240 403.2l-9.8-14.7c-4-6.1-6.2-13.2-6.2-20.4zm96 128c0 8.8 7.2 16 16 16h48c8.8 0 16-7.2 16-16s-7.2-16-16-16H352V368c0-8.8-7.2-16-16-16s-16 7.2-16 16V496zm88-98.3c0 17.3 9.8 33.1 25.2 40.8l31.2 15.6c4.6 2.3 7.6 7 7.6 12.2c0 7.5-6.1 13.7-13.7 13.7H432c-8.8 0-16 7.2-16 16s7.2 16 16 16h26.3c25.2 0 45.7-20.4 45.7-45.7c0-17.3-9.8-33.1-25.2-40.8l-31.2-15.6c-4.6-2.3-7.6-7-7.6-12.2c0-7.5 6.1-13.7 13.7-13.7H480c8.8 0 16-7.2 16-16s-7.2-16-16-16H453.7c-25.2 0-45.7 20.4-45.7 45.7z"/></svg>
                        Descargar
                    </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    
                    <?php if(isset($_SESSION['activo']) && $_SESSION['esAdmin'] == 0) : ?>
                      <a href="crear_proyecto.php" type="button" class="btn btn-primary btn-xl pull-right w-100">
                        <i class="fa fa-plus"></i> Nuevo Proyecto
                      </a>
                    <?php endif; ?> 
                  </div>

              <!-- /.card-header -->
              <div class="card-body">
                <table id="tblProyectos" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th><b>Id</b></th>
                    <th><b>Proyecto</b></th>
                    <th><b>C. de negocio</b></th>               
                    <th><b>Metas</b></th>
                    <th><b>Valores</b></th>
                    <th><b>Retos</b></th>
                    <th><b>Dolores</b></th>
                    <th><b>Comunidad</b></th>  
                    <th><b>Colaboradores</b></th>                
                    <th><b>Acciones &nbsp;</b></th>
                  </tr>
                  </thead>
                  <tbody> 
                  <?php foreach($registros as $fila) : ?>
                      <tr>
                          <td><?php echo $fila->idproyecto; ?></td>
                          <td><?php echo $fila->nombre_proyecto; ?></td>
                          <td><?php echo $fila->concepto_negocio; ?></td>
                          <td><?php echo $fila->metas; ?></td> 
                          <td><?php echo $fila->valores; ?></td> 
                          <td><?php echo $fila->retos; ?></td> 
                          <td><?php echo $fila->dolores; ?></td> 
                          <td><?php echo $fila->comunidad; ?></td> 
                          <td><?php echo $fila->colaboradores; ?></td> 
                          <td>
                          <?php if(isset($_SESSION['activo']) && $_SESSION['esAdmin'] == 0) : ?>
                                <a href="editar_proyecto.php?id=<?php echo $fila->idproyecto; ?>" class="btn btn-warning"></i> <i class="fas fa-edit"></i> Editar</a>
                                &nbsp;
                                <a href="borrar_proyecto.php?id=<?php echo $fila->idproyecto; ?>" class="btn btn-danger"></i> <i class="fas fa-trash-alt"></i> Borrar</a>                                               
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
    $('#tblProyectos').DataTable({
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
