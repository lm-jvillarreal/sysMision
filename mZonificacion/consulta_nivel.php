<?php
include '../global_seguridad/verificar_sesion.php';
$id_cara=$_POST['id_cara'];
$cadenaNivel="SELECT IFNULL(MAX(NIVEL),1)  FROM inv_detallemuebles WHERE ID_FRACCION='$id_cara'";
$consultaNivel=mysqli_query($conexion,$cadenaNivel);
$rowNivel=mysqli_fetch_array($consultaNivel);
$datos=json_encode(array(
  $rowNivel[0]
));

echo $datos;
?>