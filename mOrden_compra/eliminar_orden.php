<?php
include '../global_seguridad/verificar_sesion.php';
$id_orden = $_POST['id_orden'];
$cadena_eliminar = "DELETE FROM orden_compra WHERE id = '$id_orden'";
$consulta_elimina = mysqli_query($conexion, $cadena_eliminar);
echo "ok";
?>