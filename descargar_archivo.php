<?php
//Incluir la conexion
include_once("conexion_sql.php");

// Obtener el nombre del archivo desde la URL
$id = $_GET['id'];

// Buscar el archivo en la base de datos
$query = "SELECT * FROM actividades WHERE idactividad = '$id'";
    $stmt = $conn->query($query);
    $registro = $stmt->fetchAll(PDO::FETCH_OBJ);

    if ($registro) {
        $error = "El proyecto ya se encuentra registrado";
        foreach($registro as $fila) :
        //$fila = mysqli_fetch_assoc($registro);
            $archivo = $fila->archivo;
            $ruta_archivo = "dist/files/" . $archivo;
        endforeach;

            // Verificar que el archivo exista en el servidor
            if (file_exists($ruta_archivo)) {
                // Enviar el archivo al navegador
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="' . $archivo . '"');
                readfile($ruta_archivo);
       }else{
            echo "<script language='JavaScript'>
            alert('Archivo no encontrado.');
            location.assign('panel.php');
            </script>";
       }
    }
?>