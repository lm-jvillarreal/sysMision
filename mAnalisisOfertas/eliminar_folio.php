<?php
include '../global_seguridad/verificar_sesion.php';

$folio = $_POST['folio'];

$cadenaEliminar = "DELETE FROM registro_ofertas WHERE folio_oferta = '$folio'";
$eliminarFolio = mysqli_query($conexion, $cadenaEliminar);

echo "ok";
?>