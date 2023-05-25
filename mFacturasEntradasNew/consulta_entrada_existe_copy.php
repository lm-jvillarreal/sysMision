<?php 
    include '../global_settings/conexion_oracle.php';
    include '../global_settings/conexion.php';
    date_default_timezone_set("America/Monterrey");
    
    $folio = $_POST['folio'];
    $suc = $_POST['sucursal'];
    $movimiento = $_POST["movimiento"];



    $sql = "SELECT
				COUNT( id ) 
			FROM
				notas_entrada 
			WHERE
				folio_mov = '$folio' 
				AND tipo_mov = '$movimiento' 
				AND id_sucursal = '$suc'";
				//echo "$sql";

	$exSql = mysqli_query($conexion, $sql);
	$row = mysqli_fetch_row($exSql);
	if ($row[0] == 0) {
		echo "true";
	}else{
		echo "false";
	}
 ?>
