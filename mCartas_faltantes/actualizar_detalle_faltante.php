<?php
include '../global_seguridad/verificar_sesion.php';
$id_carta = $_POST['id_carta'];
$id_orden=$_POST['id_orden'];
$orden_compra= $_POST['orden_compra'];
$id_proveedor=$_POST['id_proveedor'];
$no_proveedor=$_POST['numero_proveedor'];
$no_factura=$_POST['no_factura'];
$id_suc=$_POST['id_sucursal'];
$bodeguero=$_POST['bodeguero'];
$nombre_transportista=$_POST['nombre_transportista'];
$id_detalle = $_POST['ide'];
$cantidad_detalle = $_POST["cantidad"];
$descripcion_detalle = $_POST["descripcion"];
$unidad_medida_detalle = $_POST["unidad_medida"];
$costo_unitario = $_POST["costo_unitario"];
$total_renglon = $_POST["total_renglon"];
$total_diferencia = $_POST["total_carta"];
$comentario=$_POST['comentario_cancela'];

if($comentario=="" || is_null($comentario) || $comentario=="null"){
  echo "no";
}else{
 //Fecha y hora actual
  date_default_timezone_set('America/Monterrey');
  $fecha=date("Y-m-d"); 
  $hora=date ("h:i:s");

$conteo = count($id_detalle);
//echo $conteo;

$cadena_cancela = "UPDATE carta_faltante SET activo = '3' WHERE id = '$id_carta'";
$consulta_cancela = mysqli_query($conexion, $cadena_cancela);

$cadenaInsertar="INSERT INTO carta_faltante (id_reemplaza, id_orden, no_orden, tipo_orden, id_proveedor, numero_proveedor, no_factura, id_sucursal, fecha_elaboracion, hora_elaboracion, total_diferencia, bodeguero, transportista, activo, usuario, comentario_modifica, usuario_modifica)VALUES('$id_carta','$id_orden','$orden_compra','FALTANTE','$id_proveedor','$no_proveedor','$no_factura','$id_suc','$fecha','$hora','0','$bodeguero','$nombre_transportista','1','$id_usuario','$comentario','$id_usuario')";
//echo $cadenaInsertar;
$insertar=mysqli_query($conexion,$cadenaInsertar);

$cadenaCarta = "SELECT id FROM carta_faltante WHERE id_reemplaza='$id_carta' AND activo='1'";
$consultaCarta=mysqli_query($conexion,$cadenaCarta);
$rowCarta=mysqli_fetch_array($consultaCarta);

for ($i=0; $i < $conteo ; $i++) { 
	
	$cadenaDetalle="INSERT INTO detalle_carta_faltante (id_carta_faltante, cantidad_producto, costo_unitario, total_renglon, descripcion, unidad_medida, fecha, hora, activo, usuario)VALUES('$rowCarta[0]','$cantidad_detalle[$i]','0','0','$descripcion_detalle[$i]','$unidad_medida_detalle[$i]','$fecha','$hora','1','$id_usuario')";
	$insertarDetalle=mysqli_query($conexion,$cadenaDetalle);
}

echo $rowCarta[0];
}
?>