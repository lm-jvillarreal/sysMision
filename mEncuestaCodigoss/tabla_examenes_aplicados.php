<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

$id_examen = $_POST['id_examen'];
$filtro = (!empty($registros_propios) == '1')?" AND id_usuario = '$id_usuario'":"";
$cadena = "SELECT id, (SELECT nombre FROM examenes WHERE examenes.id = examenes_asignados.id_examen), empleado, estatus FROM examenes_asignados WHERE activo = '1' AND id_examen = '$id_examen'".$filtro;

$consulta = mysqli_query($conexion, $cadena);
$cuerpo   = "";
$numero   = 1;
while ($row = mysqli_fetch_array($consulta)){

  $cadena2 = mysqli_query($conexion,"SELECT AVG(calificacion) FROM resultados_examen WHERE id_asignado = '$row[0]'");
  $row2    = mysqli_fetch_array($cadena2);
  $calificacion = ($row2[0] == "")?"0":round($row2[0],2);

  if($row[3] == "1"){
    $icono = "play-circle";
    $color = "warning";
  }else{
    $icono = "check-circle";
    $color = "success";
  }

  $boton = "<a class='btn btn-$color' type='button' href='r_examen.php?id_asignado=$row[0]'><i class='fa fa-$icono fa-lg' aria-hidden='true'></i></a>";
  $boton_eliminar = "<button class='btn btn-danger' onclick='eliminar_aexamen($row[0])'><i class='fa fa-trash fa-lg' aria-hidden='true'></i></button>";
    
  $renglon = "
	  {
      \"#\": \"$numero\",
      \"Examen\": \"$row[1]\",
      \"Calificacion\": \"$calificacion\",
      \"Empleado\": \"$row[2]\",
      \"Ver\": \"$boton\",
      \"Eliminar\": \"$boton_eliminar\"
	  },";
	$cuerpo = $cuerpo.$renglon;
    $numero ++;
}

$cuerpo2 = trim($cuerpo, ',');
$tabla = "
["
.$cuerpo2.
"]
";
//echo $cadena_cartas;
echo $tabla;
?>