<?php 
	 error_reporting(E_ALL ^ E_NOTICE);
    include '../global_settings/conexion_oracle.php';
    include '../global_settings/conexion_supsys.php';
  	date_default_timezone_set('America/Monterrey');
  	$fecha = date('Y-m-d');
  	$hora = date('H:i:s');
  	$id_nota = $_POST['id_nota'];
  	$select = "SELECT diferencia_restante FROM notas_entrada WHERE folio_mov = '$id_nota'";
  	$exSelect = mysqli_query($conexion, $select);
  	$row = mysqli_fetch_row($exSelect);
  	echo "$row[0]";
 ?>