<?php
include '../global_seguridad/verificar_sesion.php';
$fechahora=date("Y-m-d H:i:s");
$id_remision=$_POST['id_remision'];
$motivo=$_POST['motivo'];
$cadenaCancelar="UPDATE inv_remisiones SET ESTATUS_REMISION=' 3', MOTIVO_CANCELACION='$motivo', USUARIO_CANCELA='$id_usuario', FECHAHORA_CANCELA='$fechahora' WHERE ID='$id_remision'";
$cancelar=mysqli_query($conexion,$cadenaCancelar);

//Consulta de datos
$consulta_remision = mysqli_query($conexion,"SELECT PREFIJO_REMISION, CONSECUTIVO_REMISION FROM inv_remisiones WHERE id ='$id_remision'");
$row = mysqli_fetch_array($consulta_remision);
$title = $row[0].$row[1];
$consutla_calendario = mysqli_query($conexion,"SELECT folio FROM agenda WHERE title LIKE '%$title%'");
$row2 = mysqli_fetch_array($consutla_calendario);
$eliminar_evento = mysqli_query($conexion,"DELETE FROM agenda WHERE folio = '$row2[0]'");
echo "ok";
?>