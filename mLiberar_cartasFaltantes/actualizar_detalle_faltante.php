<?php
include '../global_seguridad/verificar_sesion.php';
$id_carta=$_POST['id_carta'];
$id_detalle = $_POST['ide'];
$cantidad_detalle = $_POST["cantidad"];
$descripcion_detalle = $_POST["descripcion"];
$unidad_medida_detalle = $_POST["unidad_medida"];
$costo_unitario = $_POST["costo_unitario"];
$total_renglon = $_POST["total_renglon"];
$total_carta = $_POST['total_carta'];

 //Fecha y hora actual
  date_default_timezone_set('America/Monterrey');
  $fecha=date("Y-m-d"); 
  $hora=date ("h:i:s");

$conteo = count($id_detalle);
//echo $conteo;

for ($i=0; $i < $conteo ; $i++) { 
	$cadena_actualizar = "UPDATE detalle_carta_faltante SET cantidad_producto = '$cantidad_detalle[$i]', descripcion = '$descripcion_detalle[$i]', unidad_medida = '$unidad_medida_detalle[$i]', costo_unitario = '$costo_unitario[$i]', total_renglon = '$total_renglon[$i]' WHERE id = '$id_detalle[$i]'";
	$consulta_detalle = mysqli_query($conexion, $cadena_actualizar);

	//echo $cadena_actualizar;
}

$total_diferencia = array_sum($total_renglon);

	$cadena_carta_faltante = "UPDATE carta_faltante SET fecha_afectacion = '$fecha', hora_afectacion = '$hora', total_diferencia = '$total_carta',  activo = '2' WHERE id IN (SELECT id_carta_faltante FROM detalle_carta_faltante WHERE id = '$id_detalle[0]')";
	$ejecutar_cadena = mysqli_query($conexion, $cadena_carta_faltante);
echo "<script>window.open('carta_faltante_pdf.php?id=".$id_carta."', '_blank');</script>";
echo "<script>window.location.href = 'index.php';</script>";
?>