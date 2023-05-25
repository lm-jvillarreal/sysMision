<?php
include '../global_seguridad/verificar_sesion.php';
//Fecha y hora actual
  date_default_timezone_set('America/Monterrey');
  $fecha=date("Y-m-d"); 
  $hora=date ("h:i:s");
	$sucursal = $_POST['sucursal'];
	if($sucursal==""){
		$filtro_sucursal = ($solo_sucursal=="0") ? "" : " AND carta_faltante.id_sucursal='$id_sede'";
	}else{
		$filtro_sucursal = ($solo_sucursal=="0") ? " AND carta_faltante.id_sucursal='$sucursal'" : " AND carta_faltante.id_sucursal='$id_sede'";
	}
	$fecha_inicio = (!isset($_POST['fecha_inicial'])) ? $fecha : $_POST['fecha_inicial'];
	$fecha_fin = (!isset($_POST['fecha_final'])) ? $fecha : $_POST['fecha_final'];
	$filtro_proveedor = ($_POST['proveedor']=="") ? "" : " AND carta_faltante.numero_proveedor='".$_POST['proveedor']."'";

$cadena_cartas = "SELECT
					carta_faltante.id,
					carta_faltante.id_orden,
					carta_faltante.no_orden,
					carta_faltante.tipo_orden,
					carta_faltante.numero_proveedor,
					proveedores.proveedor,
					carta_faltante.no_factura,
					sucursales.nombre,
					carta_faltante.activo
				FROM
					carta_faltante
					INNER JOIN proveedores ON carta_faltante.id_proveedor = proveedores.id
					INNER JOIN sucursales ON carta_faltante.id_sucursal = sucursales.id
					WHERE (carta_faltante.fecha_elaboracion >= '$fecha_inicio' AND carta_faltante.fecha_elaboracion <= '$fecha_fin')".$filtro_sucursal;
$consulta_cartas = mysqli_query($conexion, $cadena_cartas);
$cuerpo ="";
//echo $cadena_cartas;
while ($row_cartas=mysqli_fetch_array($consulta_cartas)) {
$ver_pdf = "<center><a href='carta_faltante_pdf.php?id=$row_cartas[0]' class='btn btn-success' target='blank'><i class='fa fa-search fa-lg' aria-hidden='true'></i></a></center>";
$totales = "<center><a href='carta_faltante.php?id=$row_cartas[0]' class='btn btn-danger'><i class='fa fa-pencil-square-o fa-lg' aria-hidden='true'></i></a></center>";

$status = "";
if($row_cartas[8]=="1"){
	$status = "<center><span class='label label-warning' onclick='cancelar($row_cartas[0])'>Sin afectar</span></center>";
}elseif($row_cartas[8]=="2"){
	$status = "<center><span class='label label-success' onclick='cancelar($row_cartas[0])'>Afectado</span></center>";
}elseif($row_cartas[8]=="3"){
	$status = "<center><span class='label label-danger' onclick='activar($row_cartas[0])'>Cancelado</span></center>";
	$ver_pdf = "";
	$totales = "";
}
$escape_prov=mysqli_real_escape_string($conexion,$row_cartas[5]);
	$renglon = "
		{
		 \"folio\": \"$row_cartas[0]\",
	   \"no_orden\": \"$row_cartas[2]\",
	   \"clave_proveedor\": \"$row_cartas[4]\",
	   \"proveedor\": \"$escape_prov\",
	   \"no_factura\": \"$row_cartas[6]\",
	   \"sucursal\": \"$row_cartas[7]\",
	   \"status\": \"$status\",
	   \"ver\": \"$ver_pdf\",
	   \"totales\": \"$totales\"
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