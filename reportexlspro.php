<?php
    //Inicia la conexion
    session_start();

    //Validamos si esta logueado
    if (!$_SESSION['esAdmin'] == 1) {
        header("Location:index.php");
    }

    //Incluir la DB
    include_once('conexion_sql.php');

    header("Content-Type: application/xls");    
    header("Content-Disposition: attachment; filename=Proyectos_GT_" .date('Y:m:d:m:s').".xls");
    header("Pragma: no-cache"); 
    header("Expires: 0");

    $output = "";

    $output='
    <style>
        #customers {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
        margin: -20px;
        text-align: center;
        }

        #tr {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
            margin: -20px;
            text-align: center;
        }

    </style>

    <meta charset="UTF-8">
        <div style="text-align: center;">
        <h1>Proyectos GT</h1>
        <h4>Fundación Kellogg W.K</h4>
        </div>
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
            <tbody>
    ';

    $query = "SELECT * FROM proyectos INNER JOIN alumnos ON proyectos.idalumno = alumnos.idalumno";
    $stmt = $conn->query($query);
    $stmt->execute();
    $alumnos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach($alumnos as $key=>$value){

    $output.='
        <tr id="tr">
            <td>'.$value['idproyecto'].'</td>
            <td>'.$value['nombre_proyecto'].'</td>
            <td>'.$value['concepto_negocio'].'</td>
            <td>'.$value['metas'].'</td>
            <td>'.$value['valores'].'</td>
            <td>'.$value['retos'].'</td>
            <td>'.$value['dolores'].'</td>
            <td>'.$value['comunidad'].'</td>
            <td>'.$value['colaboradores'].'</td>
            <td>'.$value['nombre']." ".$value['apellidos'].'</td>
        </tr>
    ';
    }
    

    $output.='
            </tbody>
        </table>
    ';

    echo $output

?>