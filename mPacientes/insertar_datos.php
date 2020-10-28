<?php 

    include '../global_seguridad/verificar_sesion.php';

     $id_paciente = $_POST['paciente_id'];
     $id_consulta = $_POST['consulta_id'];

     $datos_paciente = "SELECT CONCAT(nombre,' ',ap_paterno,' ',ap_materno),edad FROM pacientes WHERE id = '$id_paciente'";
     $datos = mysqli_query($conexion, $datos_paciente);
     $row_datos = mysqli_fetch_array($datos);

     $contador = "SELECT id, MAX(folio) FROM receta";
     $consulta = mysqli_query($conexion, $contador);
     $row_folio = mysqli_fetch_array($consulta);
     $folio = $row_folio[1]+1;

     date_default_timezone_set('America/Monterrey');
     $fecha=date("Y-m-d");
     $hora=date ("h:i:s");
    $notas=$_POST['notas'];

foreach (array_keys($_POST['nombre_generico']) as $key) {
     $nombre_generico = $_POST['nombre_generico'][$key];
     $nombre_farmacia = $_POST['nombre_farmacia'][$key];
     $dosis = $_POST['dosis'][$key];
     $presentacion = $_POST['presentacion'][$key];
     $via_adm = $_POST['via_adm'][$key];
     $duracion_tratamiento = $_POST['duracion_tratamiento'][$key];


         $insertar_datos = mysqli_query($conexion, "INSERT INTO `receta` (`id`, `nombre_generico`, `nombre_farmacia`, `dosis`, `presentacion`, `via_adm`, `duracion_tratamiento`, `fecha`, `notas`, `id_pacientes`, `id_medico`, `folio`, `surtido`, id_consulta) VALUES (NULL, '$nombre_generico', '$nombre_farmacia', '$dosis', '$presentacion', '$via_adm', '$duracion_tratamiento', '$fecha', '$notas', '$id_paciente', '$id_usuario', '$folio', '0', '$id_consulta')");
    }
 ?>
