<?php
include '../global_seguridad/verificar_sesion.php';
$id_renglon = $_POST['id_renglon'];
$precio_nuevo=$_POST['cantidad'];

$cadenaRenglon="SELECT  ARTC_COSTOUNITARIO FROM carniceria_costeorenglones WHERE ID='$id_renglon'";
$consultaRenglon=mysqli_query($conexion,$cadenaRenglon);
$rowRenglon=mysqli_fetch_array($consultaRenglon);

$costo_kiloartc=$rowRenglon[0];
$artc_precioventa=round($precio_nuevo,3);

//cálculos a dos decimales
$margen_artc=(1-($costo_kiloartc/$artc_precioventa))*100;
$margen_artc=round($margen_artc,3);
$cadenaActualizar="UPDATE carniceria_costeorenglones SET ARTC_MARGEN='$margen_artc', ARTC_PRECIOVENTA='$artc_precioventa' WHERE ID='$id_renglon'";
$actualizar=mysqli_query($conexion,$cadenaActualizar);
echo "ok";
?>