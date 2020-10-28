<?php
include '../global_settings/conexion.php';
$conteo=array();
//$operador=$_POST['contador'];
//$sucursal=$_POST['sucursal'];

$operador="RESTA";
$sucursal='99';

$cadenaConsulta="SELECT LIMITE_PERMITIDO, LIMITE_REAL, CONTEO_CLIENTES FROM covid_conteo_clientes WHERE sucursal='$sucursal'";
$consultaConteo=mysqli_query($conexion,$cadenaConsulta);
$rowConsulta=mysqli_fetch_array($consultaConteo);

$limite_permitido=$rowConsulta[0];
$conteo_clientes=$rowConsulta[2];
$ancla=$rowConsulta[1];

if($operador=="SUMA"){
  $conteo_real=$conteo_clientes+1;
  $ancla=$ancla+1;
  if($ancla>$limite_permitido){
    $ancla=20;
  }
}elseif($operador=="RESTA"){
  if($ancla>0){
    $conteo_real=$conteo_clientes-1;
    $ancla=$ancla-1;

    if($conteo_real>$limite_permitido && $ancla<20){
      $ancla=$limite_permitido;
    }elseif($conteo_real>0 && $conteo_real<$limite_permitido){
      $ancla=$conteo_real;
    }

  }else{
    $conteo_real=0;
    $ancla=0;
  }
}

$cadenaActualiza="UPDATE covid_conteo_clientes SET CONTEO_CLIENTES = '$conteo_real', LIMITE_REAL='$ancla' WHERE SUCURSAL='$sucursal'";
$actualizaConteo=mysqli_query($conexion,$cadenaActualiza);

array_push($conteo,array(
  'conteo'=>$ancla
));
echo utf8_encode(json_encode($conteo));

?>