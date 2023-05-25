<?php
include '../global_seguridad/verificar_sesion.php';
$fechahora=date("Y-m-d H:i:s");
$partes=$_POST['partes'];
$area=$_POST['area'];
$zona=$_POST['zona'];
$mueble=$_POST['mueble'];
$cara=$_POST['cara'];

$cadenaValidar="SELECT * FROM inv_fraccionesmueble WHERE ID_CARA ='$cara'";
$consultaValidar=mysqli_query($conexion,$cadenaValidar);
$rowValidar=mysqli_fetch_array($consultaValidar);
$conteo=count($rowValidar[0]);
if($conteo==0){
  for($i=1;$i<=$partes;$i++){
    $cadenaFracciones="INSERT INTO inv_fraccionesmueble (ID_SUCURSAL, ID_AREA, ID_ZONA, ID_TIPOMUEBLE, ID_MUEBLE, ID_CARA, FRACCION_MUEBLE, FECHAHORA, ACTIVO, USUARIO)VALUES('$id_sede','$area','$zona','','$mueble','$cara','$i','$fechahora','1','$id_usuario')";
    $consultaFracciones=mysqli_query($conexion,$cadenaFracciones);
  }
}
echo "ok";
?>