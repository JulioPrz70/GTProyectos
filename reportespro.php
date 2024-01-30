<?php
//Funcion para guardar los datos en memoria a partir de este punto
ob_start();

//Inicia la conexion
session_start();

 //Validamos si esta logueado
 if (!$_SESSION['esAdmin'] == 1) {
    header("Location:index.php");
}

//Incluir la conexion y queda de manera global para todos los archivos
include_once("conexion_sql.php");

$query = "SELECT * FROM proyectos INNER JOIN alumnos ON proyectos.idalumno = alumnos.idalumno";

$stmt = $conn->query($query);
$proyectos = $stmt->fetchAll(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte PDF</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="shortcut icon" type="opacity: .8" href="img/noveno.jpg">
    
    <style>
        #customers {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
        margin: -20px;
        text-align: center;
        }

        #customers td, #customers th {
        border: 1px solid #ddd;
        padding: 8px;
        }

        #customers tr:nth-child(even){background-color: #f2f2f2;}

        #customers tr:hover {background-color: #ddd;}

        #customers th {
        padding-top: 12px;
        padding-bottom: 12px;
        background-color: #1b5f76;
        color: white;
        text-align: center;
        }
    </style>
    
</head>
<body>
    <div style="text-align: center;">
    <h1>Proyectos GT</h1>
    <h4>Fundación Kellogg W.K</h4>
    <br>
    <br>
        <table id="customers">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Proyecto</th>
                        <th>C. de Negocio</th>
                        <th>Metas</th>
                        <th>Valores</th>
                        <th>Retos</th>
                        <th>Dolores</th>
                        <th>Comunidad</th>
                        <th>Colaboradores</th>
                        <th>Consultor</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($proyectos as $fila) : ?>
                    <tr>
                        <td><?php echo $fila->idproyecto;?></td>
                        <td><?php echo $fila->nombre_proyecto; ?></td>
                        <td><?php echo $fila->concepto_negocio; ?></td>
                        <td><?php echo $fila->metas; ?></td>
                        <td><?php echo $fila->valores; ?></td>
                        <td><?php echo $fila->retos; ?></td>
                        <td><?php echo $fila->dolores; ?></td>
                        <td><?php echo $fila->comunidad; ?></td>
                        <td><?php echo $fila->colaboradores; ?></td>
                        <td><?php echo $fila->nombre." ".$fila->apellidos; ?></td>  
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
        </table>    
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
           
</body>
</html>


<?php
    //Guardar los datos en una variable
    $html=ob_get_clean();
    
    //Importar
    require_once '../GT/libreria/dompdf/autoload.inc.php';

    //Creacion de objeto
    use Dompdf\Dompdf;
    $dompdf = new Dompdf();


    //Configurar para mostrar imagenes
    $options = $dompdf->getOptions();
    $options->set(array('isRemoteEnable' => true));
    $dompdf->setOptions($options);

    //Enviar la variable con la info guardada
    $dompdf->loadHtml($html);

    //Formato carta vertical
    //$dompdf->setPaper('letter');
    
    //Formato horizontal
    $dompdf->setPaper('A3', 'landscape');

    //Render, poder ser visible
    $dompdf->render();

    //Nombre defecto del doc y abre el doc usando False, usando true se descarga automaticamente
    $dompdf->stream("Proyectos_GT.pdf", array("Attachment" => false));


?>