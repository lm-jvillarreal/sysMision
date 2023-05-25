<?php
 include '../global_seguridad/verificar_sesion.php';
 
 $folio = $_POST['pedido'];
 $articulo = $_POST['articulo'];
 $cantidad = $_POST['cantidad'];

$cadenaInsertar = "INSERT INTO pv_renglonespedido(ID_PEDIDO,ARTC_DESCRIPCION,CANTIDAD)VALUES('$folio','$articulo','$cantidad')";
$insertarDetalle = mysqli_query($conexion,$cadenaInsertar);
echo $cadenaInsertar;
?>