<?php
include '../global_seguridad/verificar_sesion.php';
$cara=$_POST['cara'];
$cadenaValidar="SELECT * FROM inv_fraccionesmueble WHERE ID_CARA ='$cara'";
$consultaValidar=mysqli_query($conexion,$cadenaValidar);
$rowValidar=mysqli_fetch_array($consultaValidar);
$conteo=count($rowValidar[0]);
if($conteo==0){
  echo "no_existe";
}else{
  echo "si_existe";
}
?>