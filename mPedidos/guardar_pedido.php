<?php
		include "../global_settings/conexion_supsys.php";
		error_reporting(E_ALL ^ E_NOTICE);
		session_name("login_supsys"); 
		session_start();
    	date_default_timezone_set("America/Monterrey");
		$fecha = date('Y-m-d');
		$hora = date('H:i:s');
	    $s_idUsuario = $_SESSION["s_IdUser"];
	    $s_idPerfil = $_SESSION["sTipoUsuario"];
		$codigo = $_POST['codigo'];
		$cantidad = $_POST['cantidad'];
		$id_catalogo = $_POST['id_catalogo'];
		$sucursal = $_SESSION["s_Sucursal"];

		$insert = "INSERT INTO pedido_artc(id_catalogo, fecha_pedido, fecha, hora, activo, id_sucursal) VALUES('$id_catalogo', '$fecha_pedido', '$fecha', '$hora', 1, '$sucursal' )";
		$exIns = mysqli_query($conexion_mysql, $insert);
		$sel = "SELECT MAX(id) FROM pedido_artc";
		$exSel = mysqli_query($conexion_mysql, $sel);
		$max = mysqli_fetch_row($exSel);
		
		$qry = "SELECT
					COUNT(id)
				FROM
					detalle_catalogo
				WHERE
					id_catalogo = '$id_catalogo'";
		echo "$qry";
		$exQry = mysqli_query($conexion_mysql, $qry);
		$row = mysqli_fetch_row($exQry);
		$can = $row[0];

		for ($i=0; $i < $can; $i++) {
			$consulta = "INSERT INTO detalle_pedido_artc (id_pedido, codigo_producto, cantidad) VALUES('$max[0]', '$codigo[$i]', '$cantidad[$i]')";
			echo "$consulta";
        	$exConsulta = mysqli_query($conexion_mysql, $consulta);
		}
		
		



?>
