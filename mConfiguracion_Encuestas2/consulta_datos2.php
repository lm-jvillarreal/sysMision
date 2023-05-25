<?php
    // esto permite tener acceso desde otro servidor
      header('Access-Control-Allow-Origin: *');
    // esto permite tener acceso desde otro servidor
  	include '../global_settings/consulta_sqlsrvr.php';
  	include '../global_settings/conexion2.php';

  	$id_trabajador = $_POST['id_trabajador'];
  	$folio         = $_POST['folio'];

  	$cadena_persona = "SELECT codigo, (nombre + ' ' + ap_paterno + ' ' + ap_materno) AS 'nombre' FROM empleados WHERE activo = 'S' AND codigo = '$id_trabajador'";

  	$consulta_persona = sqlsrv_query($conn, $cadena_persona);
  	$row = sqlsrv_fetch_array( $consulta_persona, SQLSRV_FETCH_ASSOC);

  	$cadena2 = mysqli_query($conexion,"SELECT nombre FROM n_encuestas WHERE folio = '$folio'");
  	$row2 = mysqli_fetch_array($cadena2);

  	$array = array($row['nombre'],$row2[0]);

  	echo json_encode($array);
?>
