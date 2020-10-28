<?php
include '../global_seguridad/verificar_sesion.php';

$id_registro = $_POST['id_registro'];
$cantidad  = $_POST['folio'];

$cadenaActualizar = "UPDATE cp_detalle_receta SET cantidad ='$cantidad' WHERE id = '$id_registro'";
$actualizarCantidad = mysqli_query($conexion, $cadenaActualizar);
echo "ok";
?>