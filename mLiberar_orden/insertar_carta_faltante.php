<?php
include '../global_seguridad/verificar_sesion.php';
$id_proveedor = $_POST["id_proveedor"];
$numero_proveedor = $_POST["numero_proveedor"];
$nombre_proveedor = $_POST["nombre_proveedor"];
$orden_compra = $_POST["orden_compra"];
$id_orden = $_POST["id_orden"];
$id_sucursal = $_POST["id_sucursal"];
$nombre_sucursal = $_POST["nombre_sucursal"];

$activar = $_POST["activar"];
$cantidad = $_POST["cantidad"];
$descripcion = $_POST["descripcion"];
$unidad_medida = $_POST["unidad_medida"];

$transportista = $_POST["nombre_chofer"];
$tipo_carta = $_POST["tipo_carta"];

//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("h:i:s");

$conteo = count($activar);
//echo $conteo;

$cadena_idCarta = "SELECT id FROM carta_faltante WHERE id_orden = '$id_orden' AND no_orden = '$orden_compra'";
$ejecutar_consulta =mysqli_query($conexion, $cadena_idCarta);
$row_carta = mysqli_fetch_array($ejecutar_consulta);

$consulta_editar = "UPDATE carta_faltante SET transportista = '$transportista', tipo_orden = '$tipo_carta', bodeguero = '$nombre_persona' WHERE id = '$row_carta[0]'";
$ejecutar_editar = mysqli_query($conexion, $consulta_editar);

for ($i=0; $i < $conteo; $i++) { 
	//echo $cantidad[$i]." ".$descripcion[$i]." ".$unidad_medida[$i]."<br>";
	$total_renglon = 
	$cadena_carta_faltante = "INSERT INTO detalle_carta_faltante (id_carta_faltante, cantidad_producto, descripcion, unidad_medida, fecha, hora, activo, usuario)VALUES('$row_carta[0]','$cantidad[$i]','$descripcion[$i]','$unidad_medida[$i]','$fecha','$hora','1','$id_usuario' )";
	$insertar_carta_faltante = mysqli_query($conexion, $cadena_carta_faltante);
}
	echo "<script>window.open('carta_faltante_pdf.php?id=$row_carta[0]', '_blank');</script>";
	echo "<script>window.location.href = 'index.php';</script>";
?>