<?php 
include '../global_seguridad/verificar_sesion.php';
		$pId_mapeo = $_POST['id_mapeo'];

		$select = "SELECT contador FROM inv_mapeo WHERE id = '$pId_mapeo";
		$exSelect = mysqli_query($conexion, $select);
		$row = mysqli_fetch_row($exSelect);
		if ($row[0] == 2) {
			$qry = "DELETE FROM inv_captura WHERE id_mapeo = '$pId_mapeo'";
			$exQry = mysqli_query($conexion, $qry);
			$update = "UPDATE inv_mapeo SET activo = 1 ,  fecha_conteo = null";
			$exUp = mysqli_query($conexion, $update);
		}else{
			$qry = "DELETE FROM inv_captura WHERE id_mapeo = '$pId_mapeo'";
			$exQry = mysqli_query($conexion, $qry);
			$up = "DELETE FROM inv_mapeo  WHERE id = '$pId_mapeo'";
			$exUp = mysqli_query($conexion, $up);
			$del = "DELETE FROM inv_detalle_mapeo WHERE id_mapeo = $pId_mapeo";
			$exDel = mysqli_query($conexion, $del);
		}

	
	
 ?>