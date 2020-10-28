<?php 
	include '../global_seguridad/verificar_sesion.php';
	//include '../global_settings/conexion.php';
	include '../global_settings/conexion_oracle.php';

	$codigo = $_POST['articulo'];
	$cantidad = $_POST['cantidad'];
	$total = $_POST['total_bruto'];
	$diferencia = $_POST['diferencia'];
	$descripcion = $_POST['descripcion'];
	$folio = $_POST['folio'];
	$tipo_mov  =$_POST['tipo_mov'];
	$sucursal  =$_POST['sucursal'];
	$proveedor = $_POST['proveedor'];
	$total_impuesto = $_POST['total'];
	$dif_total = $_POST['diferencia_total'];
	$tipo_operacion = $_POST['tipo_operacion'];

	if ($dif_total == "") {
		$dif_total = 0;
	}else{
		$dif_total = $dif_total;
	}
	
	$clave_impuesto = $_POST['clave'];
	$c = count($codigo);

	$select = "SELECT
					MOVC_REFERENCIA,
					MOVC_CXP_REMISION 
				FROM
					INV_MOVIMIENTOS_LIST_VW
				WHERE
					ALMN_ALMACEN = '$sucursal'
				AND MODN_FOLIO = '$folio'
				AND MODC_TIPOMOV = '$tipo_mov'";
				echo $select;

	$st = oci_parse($conexion_central, $select);
	oci_execute($st);
	$row = oci_fetch_row($st);
	if (is_null($row[0])) {
		$factura = $row[1];
	}else{
		$factura = $row[0];
	}
	
	$insert = "INSERT INTO notas_entrada (folio_mov, tipo_mov, id_sucursal, fecha, proveedor, id_usuario, diferencia, factura, tipo_diferencia, tipo_operacion) VALUES('$folio', '$tipo_mov', '$sucursal', CURRENT_DATE, '$proveedor', '$id_usuario', '$dif_total', '$factura', 1, '$tipo_operacion')";
	echo "$insert";
	$exInsert = mysqli_query($conexion, $insert);

	$max = "SELECT MAX(id) FROM notas_entrada";
	$exMax = mysqli_query($conexion, $max);
	$row = mysqli_fetch_row($exMax);
	

	for ($i=0; $i < $c ; $i++) { 
		$impuesto = $total_impuesto[$i] - $total[$i];
		$sql = "INSERT INTO detalle_nota (id_nota, codigo_producto, cantidad, diferencia, total, descripcion, impuesto, total_impuesto, clave_impuesto) VALUES('$row[0]', '$codigo[$i]', '$cantidad[$i]', '$diferencia[$i]', '$total[$i]', '$descripcion[$i]', '$impuesto', '$total_impuesto[$i]', '$clave_impuesto[$i]')";
		echo "$sql";
		$exSql = mysqli_query($conexion, $sql);
	}
 ?>