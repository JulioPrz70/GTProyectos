<?php 
//Validamos si esta logueado
if(isset($_SESSION['activo']) && $_SESSION['esAdmin'] == 1):
  header("Location:panel.php");
endif;

include "includes/header.php";

//Mostrar registros
$query = "SELECT * FROM alumnos";
$stmt = $conn->query($query);
$alumnos = $stmt->fetchAll(PDO::FETCH_OBJ);

//var_dump($registros);

?>

              <div class="card-header">               
                <div class="row">
                  <div class="col-md-9 mt-3 mb-3">
                    <h3 class="card-title">Lista de todos los Estudiantes</h3>
                  </div>
              </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="tblAlumnos" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th><b>Id</b></th>                  
                    <th><b>Nombre</b></th>
                    <th><b>Apellidos</b></th>
                    <th><b>Edad</b></th> 
                    <th><b>Sexo</b></th> 
                    <th><b>Carrera</b></th> 
                    <th><b>Email</b></th>   
                    <th><b>Proyectos</b></th>   
                    <th><b>Acción</b></th>                
                  </tr>
                  </thead>
                  <tbody>
                  <?php foreach($alumnos as $fila) : ?>
                   <tr>
                          <td><?php echo $fila->idalumno; ?></td>
                          <td><?php echo $fila->nombre; ?></td>
                          <td><?php echo $fila->apellidos; ?></td>
                          <td><?php echo $fila->edad; ?></td>
                          <td><?php echo $fila->sexo; ?></td>
                          <td><?php echo $fila->carrera; ?></td>
                          <td><?php echo $fila->email; ?></td>
                          <td>
                            <a href="lista_proyectos.php?id=<?php echo $fila->idalumno; ?>" class="btn btn-success"><i class="bi bi-search"></i> <i class="fas fa-search"></i> Consultar</a>
                          </td> 
                          <td>
                            <a href="editar_alumno.php?id=<?php echo $fila->idalumno; ?>" class="btn btn-warning"><i class="bi bi-edit"></i> <i class="fas fa-edit"></i> Modificar</a>
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
    $('#tblAlumnos').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });  

    

    //Timepicker
    $('#timepicker').datetimepicker({
        format: 'HH:mm',        
        enabledHours: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24],
        stepping: 30
    })
  
  });
</script>
            