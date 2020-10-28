<?php 
    error_reporting(E_ALL ^ E_NOTICE);
    include '../global_settings/conexion_oracle.php';
    include '../global_settings/conexion_supsys.php';
    session_name("login_supsys"); 
    session_start();
    date_default_timezone_set("America/Monterrey");
    $fecha = date('Y-m-d');
    $hora = date('H:i:s');
    // $s_idUsuario = $_SESSION["s_IdUser"];
    // $s_idPerfil = $_SESSION["sTipoUsuario"];
    // $pId_sucursal = $_POST['id_sucursal'];
    $movimiento = $_POST['movimiento'];
    $sucursal = $_POST['sucursal'];
    $folio = $_POST['folio'];

    $select = "SELECT
					MODN_FOLIO,
					MODC_TIPOMOV,
					CC_DESCRIPCION,
					PROCNOMBRE,
					TMOVDESCRIPCION,
					MOVC_REFERENCIA,
					MOVC_CXP_REMISION
				FROM
					INV_MOVIMIENTOS_LIST_VW
				WHERE
					ALMN_ALMACEN = '$sucursal'
				AND MODN_FOLIO = '$folio'
				AND MODC_TIPOMOV = '$movimiento'";
				//echo $select;

	$st = oci_parse($conexion_central, $select);
	oci_execute($st);
	$row = oci_fetch_row($st);
	$array = array(
					$row[0], 
					$row[1], 
					$row[2],
					$row[3],
					$row[4], 
					$row[5],
					$row[6],
					$sucursal
				);
	$array_datos = json_encode($array);
	echo "$array_datos";
 ?>