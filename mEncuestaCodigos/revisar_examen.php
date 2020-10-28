<?php
	include '../global_seguridad/verificar_sesion.php';
  	include '../global_settings/conexion_oracle.php';
	
	$id_asignado = $_POST['id_asig'];
	$respuesta   = $_POST['respuesta'];
	$codigo      = $_POST['codigo'];
	$cantidad    = count($codigo);	
	$resultado   = 0;


	$cadena_p = mysqli_query($conexion,"SELECT examenes.tipo_examen FROM examenes_asignados INNER JOIN examenes ON examenes.id = examenes_asignados.id_examen WHERE examenes_asignados.id = '$id_asignado'");
	$row = mysqli_fetch_array($cadena_p);

	for ($i=0; $i < $cantidad ; $i++){ 
		if($row[0] == 1){ //Codigos
			if($codigo[$i] == $respuesta[$i]){
				$resultado = 10;
			}else{
				$resultado = 0;
			}
		}else if($row[0] == 2){ //Descripcion
			$st = oci_parse($conexion_central, "SELECT ARTC_DESCRIPCION FROM PV_ARTICULOS WHERE ARTC_ARTICULO = '$codigo[$i]'");
			oci_execute($st);
			$row_producto = oci_fetch_row($st);
			$texto = strtoupper($respuesta[$i]);
			similar_text($row_producto[0], $texto, $porcentaje);
			if($porcentaje > 50){
				$resultado = 10;
			}else{
				$resultado = 0;
			}

		}else{ //Imagen
			if($respuesta[$i] == $codigo[$i]){
				$resultado = 10;
			}else{
				$resultado = 0;
			}

		}
		$cadena = mysqli_query($conexion,"INSERT INTO resultados_examen (id_asignado, codigo, respuesta, calificacion, fecha, hora, activo, id_usuario) VALUES ('$id_asignado','$codigo[$i]','$respuesta[$i]','$resultado','$fecha','$hora','1','$id_usuario')");
	}
	$update = mysqli_query($conexion,"UPDATE examenes_asignados SET estatus = '2' WHERE id = '$id_asignado'");
	echo "ok";

	// echo $id_asignado.' - '.$respuesta[0].' - '.$codigo[0].' - '.$cantidad;

?>