<?php
include '../global_seguridad/verificar_sesion.php';

$cadenaConsulta = "SELECT * FROM detalle_checklist where id_checklist ='5'";
$consulta = mysqli_query($conexion,$cadenaConsulta);
while($rowConsulta=mysqli_fetch_array($consulta)){
  $cadenaInsertar = "INSERT INTO detalle_checklist (nombre, id_checklist, programada, id_subdepartamento, activo, fecha, hora, id_usuario, fecha_inicio, hora_inicio, se_repite, frecuencia, duracion, finaliza)VALUES('$rowConsulta[1]','12','$rowConsulta[3]','$rowConsulta[4]', '$rowConsulta[5]','$rowConsulta[6]','$rowConsulta[7]','$rowConsulta[8]','$rowConsulta[9]','$rowConsulta[12]','$rowConsulta[13]','$rowConsulta[14]','$rowConsulta[22]','$rowConsulta[23]')";
  $insertar=mysqli_query($conexion,$cadenaInsertar);
}
echo "ok";
?>