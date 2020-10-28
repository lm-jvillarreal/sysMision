<?php 
	include 'conexion_servidor.php';
    session_name("login_supsys"); 
    session_start();
	date_default_timezone_set('America/Monterrey');
	$fecha = date('Y-m-d');
	$hora = date('H:i:s');
    $sucursal = $_SESSION["s_Sucursal"];
    $s_idUsuario = $_SESSION["s_IdUser"];
	$turno = $_POST['turno'];
	$num_prov = $_POST['valor'];
	$proveedor = $_POST['nombre'];
	$tipo = $_POST['tipo'];

	$select = "SELECT MAX(turno) FROM turnos WHERE fecha = '$fecha'";
	$exSelect = mysqli_query($conexion, $select);
	$turno = mysqli_fetch_row($exSelect);
	if (is_null($turno[0])) {
		$turno[0] = 0;
	}else{
		$turno[0] = $turno[0];
	}

	$turno_nuevo = $turno[0] + 1;

	$qry ="INSERT INTO turnos (
				turno,
				num_prov,
				proveedor,
				estatus,
				id_sucursal,
				fecha,
				hora,
				usuario,
				tipo
			)
			VALUES
				(
					'$turno_nuevo',
					'$num_prov',
					'$proveedor',
					1,
					'$sucursal',
					'$fecha',
					'$hora',
					'$s_idUsuario',
					'$tipo'
				)";
	$exQry = mysqli_query($conexion, $qry);
 ?>