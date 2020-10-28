<?php
include '../global_seguridad/verificar_sesion.php';

$codigo = $_POST['folio'];
$id_registro = $_POST['id_registro'];

$cadenaActualizar = "UPDATE cp_productos SET artc_articulo = '$codigo' WHERE id = '$id_registro'";
$actualizarCodigo = mysqli_query($conexion, $cadenaActualizar);
echo "ok";
?>