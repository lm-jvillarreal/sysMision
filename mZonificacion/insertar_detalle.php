<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set("America/Monterrey");
$fechahora=date("Y-m-d H:i:s");

$area=$_POST['area'];
$zona=$_POST['zona'];
$mueble=$_POST['mueble'];
$cara=$_POST['cara'];
$fraccion=$_POST['fraccion'];
$nivel=$_POST['nivel'];
$artc_articulo=$_POST['artc_articulo'];
$artc_descripcion=$_POST['artc_descripcion'];
$artc_frente=$_POST['artc_frente'];
$artc_alto=$_POST['artc_alto'];
$artc_fondo=$_POST['artc_fondo'];
$artc_capacidad=$artc_frente*$artc_fondo*$artc_alto;

$cadenaDetalle="INSERT INTO inv_detallemuebles (ID_SUCURSAL, ID_AREA, ID_ZONA, ID_MUEBLE, ID_CARA, ID_FRACCION, NIVEL, ARTC_ARTICULO, ARTC_DESCRIPCION, ARTC_FRENTE, ARTC_ALTO, ARTC_FONDO, ARTC_CAPACIDAD, FECHAHORA, ACTIVO, USUARIO)VALUES('$id_sede','$area','$zona','$mueble','$cara','$fraccion','$nivel','$artc_articulo','$artc_descripcion','$artc_frente','$artc_alto','$artc_fondo','$artc_capacidad','$fechahora','1','$id_usuario')";
$consultaDetalle=mysqli_query($conexion,$cadenaDetalle);
echo $cadenaDetalle;
?>