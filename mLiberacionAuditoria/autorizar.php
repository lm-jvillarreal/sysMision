<?php
include '../global_seguridad/verificar_sesion.php';

date_default_timezone_set('America/Monterrey');
$fecha = date('Y-m-d');
$hora = date('H:i:s');
$fecha_impreso = date('Y-m-d H:i:s');

$id_solicitud = $_POST['id_solicitud'];

$cadena_total = "SELECT COUNT(id) FROM detalle_solicitud WHERE id_solicitud = '$id_solicitud'";
$consulta_total = mysqli_query($conexion, $cadena_total);
$row_total = mysqli_fetch_array($consulta_total);

$cadena_cero = "SELECT COUNT(id) FROM detalle_solicitud WHERE id_solicitud = '$id_solicitud' AND cantidad='0'";
$consulta_total = mysqli_query($conexion, $cadena_cero);
$row_cero = mysqli_fetch_array($consulta_total);

$calificacion = ($row_cero[0]*100)/$row_total[0];

if($calificacion<100){
	$cadena_autorizar = "UPDATE solicitud_etiquetas SET estatus = '3', fecha_autorizacion='$fecha_impreso', usuario_autorizacion='$id_usuario' WHERE id = '$id_solicitud'";
}elseif($calificacion==100){
	$cadena_autorizar = "UPDATE solicitud_etiquetas SET estatus = '2', calificacion = '$calificacion', fecha_impresion = '$fecha_impreso', usuario_imprime = '0', fecha_autorizacion='$fecha_impreso', usuario_autorizacion='$id_usuario' WHERE id = '$id_solicitud'";
}
$autorizar_solicitud = mysqli_query($conexion, $cadena_autorizar);

$consulta_calendario = mysqli_query($conexion,"SELECT folio, title, start, end, backgroundColor, borderColor FROM agenda WHERE title LIKE '$id_solicitud%'");
$row2 = mysqli_fetch_array($consulta_calendario);
$existe = mysqli_num_rows($consulta_calendario);
if($existe == 0){

}else{
	$cadena_verificar = mysqli_query($conexion,"SELECT SUM(cantidad) FROM detalle_solicitud WHERE id_solicitud = '$id_solicitud'");
	$row_c = mysqli_fetch_array($cadena_verificar);
	$eliminar_evento = mysqli_query($conexion,"DELETE FROM agenda WHERE folio = '$row2[0]'");
	if($row_c[0] != 0){
		$cadena_eventos = mysqli_query($conexion,"SELECT usuarios.id,usuarios.nombre_usuario
	                        FROM usuarios
	                        INNER JOIN personas ON personas.id = usuarios.id_persona
	                        WHERE personas.id_sede = '$id_sede' AND usuarios.id_perfil = '11' OR usuarios.id = '2'");
		while($row_e = mysqli_fetch_array($cadena_eventos)){
	    	$cadena = mysqli_query($conexion,"INSERT INTO agenda (folio,title,start,end,id_usuario,fecha,hora,backgroundColor,borderColor)
			VALUES ('$row2[0]','$row2[1]','$row2[2]','$row2[3]','$row_e[0]','$fecha','$hora','$row2[4]','$row2[5]')");
		}
	}
}

echo "ok";
?>