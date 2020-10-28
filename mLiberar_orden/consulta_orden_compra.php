<?php
include '../global_seguridad/verificar_sesion.php';

$id_orden = $_POST['id_orden'];

$cadena_consulta = "SELECT
					orden_compra.id,
	                proveedores.numero_proveedor,
	                proveedores.proveedor,
	                orden_compra.orden_compra
	                
	            FROM
	                proveedores
	            INNER JOIN orden_compra ON proveedores.numero_proveedor = orden_compra.id_proveedor
	            WHERE orden_compra.id = '$id_orden'";
  $consulta_proveedor = mysqli_query($conexion, $cadena_consulta);

  $row_proveedor = mysqli_fetch_array($consulta_proveedor);

$array = array(
	$row_proveedor[1],
	$row_proveedor[2],
	$row_proveedor[3]
);
$array_datos = json_encode($array);
echo $array_datos;
?>