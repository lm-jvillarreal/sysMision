<?php
include '../global_seguridad/verificar_sesion.php';
$fechahora=date("Y-m-d H:i:s");
$artc_articulo = $_POST['artc_articulo'];
$artc_descripcion=$_POST['artc_descripcion'];
$proveedor=$_POST['proveedor'];
$costo_empaque=$_POST['costo_empaque'];
$unidad_empaque=$_POST['unidad_empaque'];
$unidad_medida=$_POST['unidad_medida'];
$factor_empaque=$_POST['factor_empaque'];
$merma=$_POST['merma'];

$cadenaExiste="SELECT COUNT(ID) FROM tortilleria_articulos WHERE ARTC_ARTICULO='$artc_articulo'";
$consultaExiste=mysqli_query($conexion,$cadenaExiste);
$rowExiste=mysqli_fetch_array($consultaExiste);
if($rowExiste[0]>0){
  echo "existe";
}else{
  $cadenaInsertar="INSERT INTO tortilleria_articulos (ARTC_ARTICULO, ARTC_DESCRIPCION, PROVEEDOR, RMON_ULTIMOPRECIO, UNIMEDIDA_COMPRA, UNIMEDIDA_VENTA, FACTOR_EMPAQUE, PORCENTAJE_MERMA, FECHAHORA, ACTIVO, USUARIO)VALUES('$artc_articulo','$artc_descripcion','$proveedor','$costo_empaque','$unidad_empaque','$unidad_medida','$factor_empaque','$merma','$fechahora','1','$id_usuario')";
  $insertar=mysqli_query($conexion,$cadenaInsertar);
  echo "ok";
}
?>