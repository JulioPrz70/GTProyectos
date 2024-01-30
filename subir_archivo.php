<?php
//Incluir la conexion
include_once("conexion_sql.php");

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
    }
}
?>