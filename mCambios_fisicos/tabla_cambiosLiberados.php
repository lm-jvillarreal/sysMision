<?php
include '../global_seguridad/verificar_sesion.php';
//Fecha y hora actual
  date_default_timezone_set('America/Monterrey');
  $fecha=date("Y-m-d"); 
  $hora=date ("h:i:s");
  //$proveedor = $_POST['proveedor'];
  //$filtro_proveedor = "AND d.numero_proveedor = '".$proveedor."'";
if ($solo_sucursal == '1') {
	$filtro_sucursal = " AND cambios.id_sucursal = '$id_sede'";
}elseif($solo_sucursal == '0'){
	$filtro_sucursal = "";
}
$cadena_cambios = "SELECT cambios.id, cambios.id_proveedor, cambios.codigo, cambios.producto, cambios.cantidad, proveedores.proveedor, DATE_FORMAT(cambios.fecha_liberacion, '%d/%m/%Y'),cambios.id_sucursal FROM  cambios INNER JOIN proveedores ON cambios.id_proveedor = proveedores.numero_proveedor AND cambios.estatus = '1'".$filtro_sucursal;

$consulta_cambios = mysqli_query($conexion, $cadena_cambios);
$cuerpo ="";

while ($row_cambios=mysqli_fetch_array($consulta_cambios)) {
	$liberar = "<a href='javascript:liberar_cambioFisico($row_cambios[0])' class='btn btn-success'>Liberar</a>";
	$proveedor = $row_cambios[1]." - ".$row_cambios[5];
	$producto = $row_cambios[2]." - ".$row_cambios[3];
	$renglon = "
		{
		\"folio\": \"$row_cambios[0]\",
		\"proveedor\": \"$proveedor\",
		\"producto\": \"$producto\",
		\"cantidad\": \"$row_cambios[4]\",
		\"sucursal\": \"$row_cambios[7]\",
		\"liberado\": \"$row_cambios[6]\"
	  },";
	$cuerpo = $cuerpo.$renglon;
}
$cuerpo2 = trim($cuerpo, ',');
$tabla = "
["
.$cuerpo2.
"]
";
//echo $cadena_cartas;
echo $tabla;

//echo $liberar;
?>