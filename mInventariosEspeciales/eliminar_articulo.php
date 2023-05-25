<?php
include '../global_seguridad/verificar_sesion.php';
$artc_articulo=$_POST['articulo'];
$categoria=$_POST['categoria'];
$cadenaEliminar="DELETE FROM vidvig_categorias WHERE FOLIO='$categoria' AND ARTC_ARTICULO='$artc_articulo'";
$eliminarArticulo=mysqli_query($conexion,$cadenaEliminar);
echo "ok";
?>