<?php 
include '../global_seguridad/verificar_sesion.php';
	include '../global_settings/conexion_oracle.php';

	$fecha = date('Y-m-d');
	$hora = date('H:i:s');
	$id_mapeo = $_POST['id_mapeo'];
	$consecutivo = $_POST['consecutivo'];
	$estante = $_POST['estante'];
	$codigo= $_POST['codigo'];
  $max = "SELECT MAX(inv_detalle_mapeo.id) FROM inv_detalle_mapeo";
  $exMax = mysqli_query($conexion, $max);
  $rowMax = mysqli_fetch_row($exMax);
  $id = $rowMax[0]+1;
  $sql_o = "SELECT artc_descripcion FROM COM_ARTICULOS WHERE ARTC_ARTICULO = '$codigo'";
	$st = oci_parse($conexion_central, $sql_o);
	oci_execute($st);
	$row = oci_fetch_row($st);
	$qry = "UPDATE inv_detalle_mapeo
    			SET consecutivo_mueble = consecutivo_mueble + 1
    			WHERE consecutivo_mueble >= '$consecutivo'
    			AND estante = '$estante'
    			AND id_mapeo = $id_mapeo";
	$exQry = mysqli_query($conexion, $qry);
	$insert = "INSERT INTO inv_detalle_mapeo (
              id,
							id_mapeo,
							consecutivo_mueble,
							estante,
							codigo_producto,
							fecha,
							usuario,
							activo,
							descripcion
						)
				VALUES
					('$id','$id_mapeo','$consecutivo', '$estante','$codigo', '$fecha', '1', '1', '$row[0]')";
	$exIns = mysqli_query($conexion, $insert);

 ?>
