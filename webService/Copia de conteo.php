<?php
include '../global_settings/conexion.php';
$conteo=array();
//$operador="RESTA";
//$sucursal='1';
$operador=$_POST['contador'];
$sucursal=$_POST['sucursal'];

$cadenaConsulta="SELECT LIMITE_PERMITIDO, LIMITE_REAL, CONTEO_CLIENTES FROM covid_conteo_clientes WHERE sucursal='$sucursal'";
$consultaConteo=mysqli_query($conexion,$cadenaConsulta);
$rowConsulta=mysqli_fetch_array($consultaConteo);

$limite_permitido=$rowConsulta[0];
$limite_real=$rowConsulta[1];
$conteo_clientes=$rowConsulta[2];

if($limite_permitido<$limite_real){
  $diferencia=$limite_real-$limite_permitido;
  if($conteo_clientes>=$limite_permitido){
    $clientes=$conteo_clientes-$diferencia;
    if($clientes<0){
      $clientes=0;
    }
    elseif($clientes>=0 && $clientes<=19){
      $clientes=$clientes+20;
    }else{
      $clientes=$clientes;
    }
  }else{
    $clientes=$conteo_clientes;
  }
}else{
  $clientes=$conteo_clientes;
}

if($operador=="SUMA"){
  if($clientes<$limite_permitido){
    $clientes=$clientes+1;
    $conteo_real=$conteo_clientes+1;
  }else{
    $clientes=$clientes;
    $conteo_real=$conteo_clientes;
  }
}else if($operador=="RESTA"){
  if($clientes>0){
    $clientes=$clientes-1;
    $conteo_real=$conteo_clientes-1;
  }else{
    $clientes=$clientes;
    $conteo_real=$conteo_clientes;
  }
  
}

$cadenaActualiza="UPDATE covid_conteo_clientes SET CONTEO_CLIENTES = '$conteo_real' WHERE SUCURSAL='$sucursal'";
$actualizaConteo=mysqli_query($conexion,$cadenaActualiza);

array_push($conteo,array(
  'conteo'=>$clientes
));
echo utf8_encode(json_encode($conteo));
?>