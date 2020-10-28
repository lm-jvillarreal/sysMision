<?php
include '../global_seguridad/verificar_sesion.php';

$folio = $_POST['folio'];
$id_boleto = $_POST['id_boleto'];

$cadena_actualizar = "UPDATE registro_boletos SET folio_boleto = '$folio', estatus='2' WHERE id = '$id_boleto' AND sucursal = '$id_sede'";
$actualiza_folio = mysqli_query($conexion, $cadena_actualizar);
echo "ok";
?>