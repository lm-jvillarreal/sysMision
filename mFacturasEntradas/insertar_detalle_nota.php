<?php
      include '../global_settings/conexion_oracle.php';
    include '../global_settings/conexion.php';
	//error_reporting(E_ALL ^ E_NOTICE);
	session_name("login_supsys"); 
	session_start();
	date_default_timezone_set("America/Monterrey");
	$fecha = date('Y-m-d');
	$hora = date('H:i:s');
	$nota = $_POST['nota'];
	$codigo = $_POST['codigo'];
	$cantidad = $_POST['cantidad'];
	$diferencia = $_POST['diferencia'];
	$total = $_POST['valor'];
	$descripcion = $_POST['descrpicion'];

	$select = "SELECT id FROM detalle_nota WHERE codigo_producto = '$codigo' AND id_nota = '$nota'";
	$exSelect = mysqli_query($conexion, $select);
	$id = mysqli_fetch_row($exSelect);
	$num = mysqli_num_rows($exSelect);
	//echo $num;

	if ($num > 0) {
		$sql = "UPDATE detalle_nota SET cantidad = '$cantidad', diferencia = '$diferencia', total = '$total' WHERE id = '$id[0]'";
	}else{
		$sql = "INSERT INTO detalle_nota(id_nota, codigo_producto, cantidad, diferencia, total, descripcion) VALUES ('$nota', '$codigo', '$cantidad', '$diferencia', '$total', '$descripcion')";
	}
	$exSql = mysqli_query($conexion, $sql);
	//print_r($exSql);


	$sum = "SELECT
				SUM(total)
			FROM
				detalle_nota
			WHERE
				id_nota = '$nota'";
				//echo "$sum";
	$exSum = mysqli_query($conexion, $sum);
	$row_sum = mysqli_fetch_row($exSum);
	//echo "$row_sum[0]";

	$update = "UPDATE notas_entrada SET diferencia_restante = diferencia - '$row_sum[0]' WHERE id = '$nota'";
	$exUpdate = mysqli_query($conexion, $update);

	$s = "SELECT diferencia_restante FROM notas_entrada WHERE folio_mov = '$nota'";
	//echo "$s";
	$exS = mysqli_query($conexion, $s);
	$row_s = mysqli_fetch_row($exS);
	echo "$row_s[0]";

?>