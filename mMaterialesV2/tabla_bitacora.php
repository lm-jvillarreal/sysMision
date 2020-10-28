<?php 
	include '../global_seguridad/verificar_sesion.php';

	$fecha1 = $_POST['fecha1'];
	$fecha2 = $_POST['fecha2'];

	$filtro=(!empty($registros_propios) == '1')?"AND materiales_movimientos.id_usuario = '$id_usuario'":"";
	$consulta = mysqli_query($conexion,"SELECT
	( SELECT nombre FROM catalago_materiales WHERE catalago_materiales.id = materiales_movimientos.id_material ),	
	pedido_materiales.nombre,
	tipo, 
	cantidad,
	DATE_FORMAT(materiales_movimientos.fecha,'%d-%m-%Y'),
	materiales_movimientos.hora, 
	(SELECT CONCAT(personas.nombre,' ',personas.ap_paterno,' ',personas.ap_materno) FROM usuarios INNER JOIN personas ON personas.id = usuarios.id_persona WHERE usuarios.id = materiales_movimientos.id_usuario),
	id_pedido
	FROM materiales_movimientos
	LEFT JOIN pedido_materiales ON pedido_materiales.id = materiales_movimientos.id_pedido
	WHERE materiales_movimientos.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE) ".$filtro."
	ORDER BY materiales_movimientos.id DESC");

	$cuerpo  = "";
	$numero  = 1;

	while ($row = mysqli_fetch_array($consulta)) 
	{
		$horabd = substr($row[5], 0,8);
		$cantidad = ($row[2] == 1)?"<span class='label label-danger'>- ".$row[3]."</span>":"<span class='label label-success'>+ ".$row[3]."</span>";
		if($row[7] == "0"){
			$pedido = "Actualizar Existencia";
		}else if($row[7] == "100000001"){
			$pedido = "Consumo Interno";
		}else{
			$pedido = $row[1];
		}

		$renglon = "
			{
			\"#\": \"$numero\",
			\"Material\": \"$row[0]\",
            \"Pedido\": \"$pedido\",
            \"Cantidad\": \"$cantidad\",
            \"Fecha\": \"$row[4]\",
            \"Hora\": \"$horabd\",
            \"Usuario\": \"$row[6]\"
			},";
		$cuerpo = $cuerpo.$renglon;
		$numero ++;
		$pedido = "";
	}
	$cuerpo2 = trim($cuerpo,','); ///Quitarle la coma
	$tabla = "
	["
	.$cuerpo2.
	"]
	";
	echo $tabla;
 ?>