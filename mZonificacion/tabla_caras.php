<?php
include '../global_seguridad/verificar_sesion.php';
$id=$_POST['id'];
$datos=array();
$cadenaCaras="SELECT
              ID,
              TIPO_MUEBLE,
              CARA_MUEBLE,
              MOTIVO_BAJA,
              ACTIVO 
              FROM
              inv_caramuebles 
              WHERE
              ID_MUEBLE = '$id'";
$consultaCaras=mysqli_query($conexion,$cadenaCaras);
while($rowCaras=mysqli_fetch_array($consultaCaras)){
  if($rowCaras[4]=='1'){
    $baja="<center><a href='#' onclick='baja($rowCaras[0])' class='btn btn-danger'><i class='fa fa-arrow-down fa-lg' aria-hidden='true'></i></a></center>";
  }else{
    $baja="";
  }
  array_push($datos,array(
    'id'=>$rowCaras[0],
    'tipo_mueble'=>$rowCaras[1],
    'cara_mueble'=>$rowCaras[2],
    'motivo_baja'=>$rowCaras[3],
    'opciones'=>$baja
  ));
}
echo utf8_encode(json_encode($datos));
?>