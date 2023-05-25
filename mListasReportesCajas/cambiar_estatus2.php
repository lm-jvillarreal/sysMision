<?php
	include '../global_seguridad/verificar_sesion.php';
	$id = $_POST['id'];
	// echo $id;
	  $cadena = mysqli_query($conexion,"UPDATE reportes_cajas SET status = '2' WHERE id = '$id'");
	///////eliminar notificaciones///////
	 $consulta_caja = mysqli_query($conexion,"SELECT id_caja FROM reportes_cajas WHERE id ='$id'");
	 $row_caja = mysqli_fetch_array($consulta_caja);
	
	 $cadena_nombre="SELECT nombre FROM cajas where id ='$row_caja[0]'";
	 $consulta_nombre=mysqli_query($conexion, $cadena_nombre);
	 $row_nombre=mysqli_fetch_array($consulta_nombre);

	$consutla_calendario = "SELECT folio FROM agenda WHERE title LIKE '%REPORTE CAJA: -$row_nombre[0]%'";
	$cadena_calendario= mysqli_query($conexion,$consutla_calendario);
	$row2 = mysqli_fetch_array($cadena_calendario);
	$eliminar_evento = mysqli_query($conexion,"DELETE FROM agenda WHERE folio = '$row2[0]'");
	echo "ok";
?>