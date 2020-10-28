<?php 
include '../global_seguridad/verificar_sesion.php';
	//session_name("login_supsys"); 
	//session_start();
	$id_detalle = $_POST['id_detalle'];
	$codigo = $_POST['codigo'];
	$cantidad = $_POST['cantidad'];
	$id_mapeo = $_POST['id_mapeo'];
    date_default_timezone_set("America/Monterrey");

    $qry = "SELECT captura.id FROM inv_captura captura WHERE id_detalle_mapeo = '$id_detalle'";
    $exQry = mysqli_query($conexion, $qry);
    $num = mysqli_num_rows($exQry);

    if ($num >= 1) {
    	$up = "UPDATE inv_captura SET cantidad = $cantidad WHERE id_detalle_mapeo = $id_detalle";
    	$exUp = mysqli_query($conexion, $up);
    	echo "$up";

    }
    else
    {
    		$insertar = "INSERT INTO inv_captura (
					id_mapeo,
					id_detalle_mapeo,
					cod_producto,
					cantidad,
					usuario
				)
				VALUES
					(
						'$id_mapeo',
						'$id_detalle',
						'$codigo',
						'$cantidad',
						'$id_usuario'
					)";
					echo "$insertar";


	$exInsert = mysqli_query($conexion, $insertar);

    }


 ?>