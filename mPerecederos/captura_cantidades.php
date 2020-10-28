<?php 
include '../global_settings/conexion.php';
	//session_name("login_supsys"); 
	//session_start();
    $s_idUsuario = $_SESSION["s_IdUser"];
	$id_detalle = $_POST['id_detalle'];
	$codigo = $_POST['codigo'];
	$cantidad = $_POST['cantidad'];
	$id_mapeo = $_POST['id_mapeo'];
    date_default_timezone_set("America/Monterrey");

    $qry = "SELECT captura.id FROM captura WHERE captura.id_detalle_mapeo = '$id_detalle'";
    $exQry = mysqli_query($conexion, $qry);
    $num = mysqli_num_rows($exQry);

    if ($num >= 1) {
    	$up = "UPDATE captura SET cantidad = $cantidad WHERE captura.id_detalle_mapeo = $id_detalle";
    	$exUp = mysqli_query($conexion, $up);

    }
    else
    {
    		$insertar = "INSERT INTO captura (
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
						'$s_idUsuario'
					)";


	$exInsert = mysqli_query($conexion, $insertar);

    }


 ?>