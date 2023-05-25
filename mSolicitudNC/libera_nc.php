<?php
include '../global_seguridad/verificar_sesion.php';

$id_formato = $_POST['id_formato'];
$folio = $_POST['folio'];

$cadena_actualiza = "UPDATE solicitud_nc SET estatus = '2', folio = '$folio' WHERE id = '$id_formato'";
$actualiza_formato = mysqli_query($conexion, $cadena_actualiza);

echo $cadena_actualiza;
?>