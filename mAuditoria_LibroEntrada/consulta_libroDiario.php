<?php
include '../global_seguridad/verificar_sesion.php';

//Fecha y hora actual
  date_default_timezone_set('America/Monterrey');
  $fecha=date("Y-m-d"); 
  $hora=date ("h:i:s");

$fecha_inicial = (!isset($_POST['fecha_inicio'])) ? $fecha : $_POST['fecha_inicio'];
$fecha_final = (!isset($_POST['fecha_fin'])) ? $fecha : $_POST['fecha_fin'];

$filtro_sucursal = ($solo_sucursal == '1') ? " AND orden_compra.id_sucursal = '$id_sede'" : "";

$cadena_ordenes = "SELECT
					proveedores.numero_proveedor,
					proveedores.proveedor,
					DATE_FORMAT(orden_compra.fecha_final, '%d/%m/%Y'),
					libro_diario.numero_nota,
					libro_diario.numero_factura,
					libro_diario.total,
					orden_compra.hora_inicio,
					orden_compra.hora_final,
					TIMEDIFF(orden_compra.hora_final, orden_compra.hora_inicio),
					libro_diario.observaciones,
					sucursales.nombre,
					libro_diario.id,
					libro_diario.activo
				FROM
					libro_diario
					INNER JOIN proveedores ON libro_diario.id_proveedor = proveedores.numero_proveedor
					INNER JOIN orden_compra ON libro_diario.orden_compra = orden_compra.id
					AND libro_diario.sucursal = orden_compra.id_sucursal
					INNER JOIN sucursales ON libro_diario.sucursal = sucursales.id
					WHERE libro_diario.fecha >= '$fecha_inicial'
					AND libro_diario.fecha <= '$fecha_final'
					AND orden_compra.activo = '0'".
			        $filtro_sucursal.
					"ORDER BY libro_diario.numero_nota ASC";

//echo $cadena_ordenes;
$consulta_ordenes = mysqli_query($conexion, $cadena_ordenes);
$cuerpo = "";

while ($row_ordenes = mysqli_fetch_array($consulta_ordenes)) {

	$cadena_auditoria = "SELECT folio_entrada, comentario_autoriza, id FROM auditoria_libroDiario WHERE id_libroDiario = '$row_ordenes[11]'";
	$consulta_auditoria = mysqli_query($conexion, $cadena_auditoria);
	$row_auditoria = mysqli_fetch_array($consulta_auditoria);
	$folio_entradaA = $row_auditoria[0];
	$comentario_autoriza = $row_auditoria[1];
	$id_auditoria = $row_auditoria[2];
	
	$total = money_format('%(#2n', $row_ordenes[5]);

	$autorizar = "<div class='input-group' style='width:69%''><input type='text' id='folio_$row_ordenes[11]' value='$folio_entradaA' class='form-control'><span class='input-group-btn'><button onclick='libera_sistemas($row_ordenes[11])' class='btn btn-danger' type='button'><i class='fa fa-floppy-o fa-lg' aria-hidden='true'></i></button></span></div>&nbsp;<button class='btn btn-success' type='button' data-id='$id_auditoria' data-coment='$comentario_autoriza' data-toggle='modal' data-target='#modal-comentario'><i class='fa fa-commenting fa-lg' aria-hidden='true'></i></button>";
	$proveedor = $row_ordenes[0]." - ".$row_ordenes[1];
	$renglon = "
		{
		\"folio\": \"$row_ordenes[3]\",
	   	\"no_proveedor\": \"$proveedor\",
	   	\"fecha_entrada\": \"$row_ordenes[2]\",
	   	\"factura\": \"$row_ordenes[4]\",
	   	\"total\": \"$total\",
	   	\"observaciones\": \"$row_ordenes[9]\",
	   	\"autorizar\": \"$autorizar\"
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
//echo $liberar;
?>