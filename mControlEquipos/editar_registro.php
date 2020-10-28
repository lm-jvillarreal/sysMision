<?php
	include '../global_seguridad/verificar_sesion.php';
	date_default_timezone_set('America/Monterrey');
	$fecha = date("Y-m-d"); 
	$hora  = date ("h:i:s");

	$id = $_POST['id'];
	
	$cadena = mysqli_query($conexion,"SELECT
						                id_marca,
						                (SELECT marca FROM marcas WHERE marcas.id = control_equipos.id_marca),
						                id_modelo,
						                (SELECT modelo FROM modelos WHERE modelos.id = control_equipos.id_modelo),
						                numero_serie,
						                llave_banorte,
						                id_caja,
						                (SELECT CONCAT(nombre,' ',(SELECT nombre FROM sucursales WHERE sucursales.id = cajas.id_sucursal)) FROM cajas WHERE cajas.id = control_equipos.id_caja),
						                afiliacion,
						                usuario,
						                contrasena,
						                tipo,
						                cashback,
						                cifrada
						              FROM
						                control_equipos
						              WHERE
						                activo = '1' 
						              AND id = '$id'");

	$row = mysqli_fetch_array($cadena);

	$array  = array($row[0],$row[1],$row[2],$row[3],$row[4],$row[5],$row[6],$row[7],$row[8],$row[9],$row[10],$row[11],$row[12],$row[13]);
	$array1 = json_encode($array);
	
	echo $array1;
	
?>