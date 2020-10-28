<?php
include '../global_settings/conexion.php';
  date_default_timezone_set('America/Monterrey');
  $fecha=date("Y-m-d"); 
  $hora=date ("h:i:s");

  $cadena_receta = "SELECT id, fecha, folio FROM receta WHERE fecha ='$fecha'";
  // ORDER BY id DESC LIMIT 1 es para
						
	//Restricción para una sola verificación
	//AND lista_proyectos.verificado='0'
 //echo $cadena_modulos;
 $consulta_receta = mysqli_query($conexion, $cadena_receta);
 $cuerpo = "";
 
while ($row_receta = mysqli_fetch_array($consulta_receta)) {
	$imprimir= "<button onclick='' type='button' class='btn btn-warning text-center'>Imprimir</a>";

	$renglon = "
	{
		\"id\": \"$row_receta[0]\",
		\"fecha\": \"$row_receta[1]\",
		\"folio\": \"$row_receta[2]\", 
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
