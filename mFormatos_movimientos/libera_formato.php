<?php
include '../global_seguridad/verificar_sesion.php';

$id_formato = $_POST['id_formato'];
$folio = $_POST['folio'];

$cadena_actualiza = "UPDATE formatos_movimientos SET comentario_libera = '$folio', estatus='2', activo = '0', usuario_libera = '$id_usuario' WHERE id = '$id_formato'";
$actualiza_formato = mysqli_query($conexion, $cadena_actualiza);

echo "ok";
?>