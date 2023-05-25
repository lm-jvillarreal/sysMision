<?php
include '../global_settings/conexion.php';
//Fecha y hora actual
  date_default_timezone_set('America/Monterrey');
  $fecha=date("Y-m-d"); 
  $hora=date ("h:i:s");

$cadena_cartas = "SELECT
				s.nombre,
				d.folio,
				d.numero_proveedor,
				DATE_FORMAT(d.fecha, '%d/%m/%Y'),
				d.tipo,
				d.`status`,
				p.proveedor,
				d.id,
				u.nombre_usuario
			FROM
				devoluciones d
			INNER JOIN sucursales s ON s.id = d.id_sucursal
			INNER JOIN proveedores p ON p.numero_proveedor = d.numero_proveedor
			INNER JOIN usuarios u ON d.usuario = u.id
			WHERE d.`status` = '1'";

$consulta_cartas = mysqli_query($conexion, $cadena_cartas);
$cuerpo ="";
$i=0;
while ($row_cartas=mysqli_fetch_array($consulta_cartas)) {
	$i++;
	$liberar = "<a href='javascript:liberar_devolucion($row_cartas[7])' class='btn btn-success'>Liberar</a>";
	$escape_prov=mysqli_real_escape_string($conexion,$row_cartas[6]);
	$renglon = "
		{
		\"no\": \"$i\",
		\"folio\": \"$row_cartas[1]\",
	   \"movimiento\": \"$row_cartas[4]\",
	   \"proveedor\": \"$escape_prov\",
	   \"fecha\": \"$row_cartas[3]\",
	   \"sucursal\": \"$row_cartas[0]\",
	   \"usuario\": \"$row_cartas[8]\",
	   \"liberar\": \"$liberar\"
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