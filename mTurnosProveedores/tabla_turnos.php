<?php
include '../global_settings/conexion.php';
  date_default_timezone_set('America/Monterrey');
  $fecha=date("Y-m-d"); 
  $hora=date ("h:i:s");
  $prefijo = date("Y").date("m").date("d");

  $cadena_turnos = "SELECT id, fecha, consecutivo, prefijo FROM turnos WHERE fecha ='$fecha' and activo = 0";
						
	//Restricción para una sola verificación
	//AND lista_proyectos.verificado='0'
 //echo $cadena_modulos;
 $consulta_turnos = mysqli_query($conexion, $cadena_turnos);
 $cuerpo = "";
 
while ($row_turnos = mysqli_fetch_array($consulta_turnos)) {
	$imprimir= "<button onclick='reimpresion($row_turnos[2],$row_turnos[3]);' type='button' class='btn btn-warning text-center'>Imprimir</button>";
	$renglon = "
	{
		\"id\": \"$row_turnos[0]\",
		\"fecha\": \"$row_turnos[1]\",
		\"consecutivo\": \"$row_turnos[2]\", 
		\"imprimir\": \"$imprimir\"
	  },";
	$cuerpo = $cuerpo.$renglon;
}

$cuerpo2 = trim($cuerpo, ',');
$tabla = "
["
.$cuerpo2.
"]
";
echo $tabla;
?>
