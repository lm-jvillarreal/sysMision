<?php 
	include '../global_settings/conexion.php';
	$pIdCarta = $_POST['id'];
	$pIdNota = $_POST['id_nota'];
	$pTotalCarta = $_POST['total'];
	$sql = "UPDATE notas_entrada 
			SET id_carta_faltante = '$pIdCarta',
				diferencia_restante = diferencia_restante - '$pTotalCarta'
			WHERE folio_mov = '$pIdNota'";
			$exSql = mysqli_query($conexion, $sql);
	$select = "SELECT diferencia_restante FROM notas_entrada WHERE folio_mov = '$pIdNota'";
	$exSel = mysqli_query($conexion, $select);
	$row = mysqli_fetch_row($exSel);
	echo "$row[0]";
	// if ($row[0] > 0) {
	// 	echo "false";
	// }else{
	// 	echo "true";
	// }
	// 
 ?>