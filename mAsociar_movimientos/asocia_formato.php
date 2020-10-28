<?php
include '../global_seguridad/verificar_sesion.php';

$id_formato = $_POST['id_formato'];
$folio = $_POST['folio'];

$cadena_actualiza = "UPDATE formatos_movimientos SET folio_infofin = '$folio', estatus='1', usuario_asocia = '$id_sede' WHERE id = '$id_formato'";
$actualiza_formato = mysqli_query($conexion, $cadena_actualiza);

echo "ok";
?>