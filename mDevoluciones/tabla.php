<?php
include '../global_seguridad/verificar_sesion.php';
//Fecha y hora actual
  date_default_timezone_set('America/Monterrey');
  $fecha=date("Y-m-d"); 
  $hora=date ("h:i:s");
  $proveedor = !ISSET($_POST['proveedor']);
  $filtro_proveedor = ($proveedor==TRUE)? "" : " AND d.numero_proveedor = '".$proveedor."'";
  $solo_suc = ($solo_sucursal == '1') ? " AND d.id_sucursal='$id_sede'" : "";

$cadena_cartas = "SELECT
				s.nombre,
				d.folio,
				d.numero_proveedor,
				DATE_FORMAT(d.fecha, '%d/%m/%Y'),
				d.tipo,
				d.`status`,
				p.proveedor,
				d.id
			FROM
				devoluciones d
			INNER JOIN sucursales s ON s.id = d.id_sucursal
			INNER JOIN proveedores p ON p.numero_proveedor = d.numero_proveedor
			WHERE d.`status` = '0'".$solo_suc.$filtro_proveedor;

$consulta_cartas = mysqli_query($conexion, $cadena_cartas);
$cuerpo ="";

while ($row_cartas=mysqli_fetch_array($consulta_cartas)) {
	$liberar = "<a href='javascript:liberar_devolucion($row_cartas[7])' class='btn btn-success'>Liberar</a>";
	$proveedor = $row_cartas[2]." - ".$row_cartas[6];
	$renglon = "
		{
		\"folio\": \"$row_cartas[1]\",
	   \"movimientos\": \"$row_cartas[4]\",
	   \"proveedor\": \"$proveedor\",
	   \"fecha\": \"$row_cartas[3]\",
	   \"sucursal\": \"$row_cartas[0]\",
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