<?php 
	include'../global_settings/conexion.php';
    date_default_timezone_set("America/Monterrey");
	session_name("login_supsys"); 
	session_start();
    $s_idUsuario = $_SESSION["s_IdUser"];
    $pIdMapeo = $_POST['id_mapeo'];
    $pIdDetalle = $_POST['id_detalle'];
    $pCantidad = $_POST['total'];
    $pRegistros = $_POST['registros'];
    $pCodigo = $_POST['codigo'];
    $can = count($pRegistros);

	$qry = "UPDATE inv_mapeo 
			SET activo = 0
			WHERE
				inv_mapeo.id ='$pIdMapeo[0]'";

	$exQry = mysqli_query($conexion, $qry);

	for ($i=0; $i < $can; $i++) { 

	    $qry2 = "SELECT captura.id FROM inv_captura captura WHERE captura.id_detalle_mapeo = '$pIdDetalle[$i]'";
		$exQry = mysqli_query($conexion, $qry2);
    	$num = mysqli_num_rows($exQry);

    if ($num >= 1) {

    	$up = "UPDATE inv_captura SET cantidad = $pCantidad[$i] WHERE captura.id_detalle_mapeo = '$pIdDetalle[$i]'";
    	echo "$up";
    	$exUp = mysqli_query($conexion, $up);
    }

    	else{
    				$insertar = "INSERT INTO inv_captura (
					id_mapeo,
					id_detalle_mapeo,
					cod_producto,
					cantidad,
					usuario
				)
				VALUES
					(
						'$pIdMapeo[$i]',
						'$pIdDetalle[$i]',
						'$pCodigo[$i]',
						'$pCantidad[$i]',
						'$s_idUsuario'
					)";
					echo "$insertar";

			$exInsert = mysqli_query($conexion, $insertar);
    	}



	}

	

 ?>