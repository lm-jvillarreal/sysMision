<?php
include '../global_settings/conexion.php';
$conteo_=array();
//$operador=$_POST['contador'];
//$sucursal=$_POST['sucursal'];

$operador="SUMA";
$sucursal='100';

$cadenaConsulta="SELECT LIMITE_PERMITIDO, LIMITE_REAL, CONTEO_CLIENTES FROM covid_conteo_clientes WHERE sucursal='$sucursal'";
$consultaConteo=mysqli_query($conexion,$cadenaConsulta);
$rowConsulta=mysqli_fetch_array($consultaConteo);

$limite_permitido=$rowConsulta[0];
$limite_real=$rowConsulta[1];
$conteo_clientes=$rowConsulta[2];

if($operador=="SUMA"){
  if($conteo_clientes<$limite_permitido){
    $conteo=$conteo_clientes+1;
  }else{
    $conteo=$conteo_clientes;
  }
  
  
}elseif($operador=="RESTA"){
  if($conteo_clientes=='0'){
    $conteo=0;
  }else{
    $conteo=$conteo_clientes-1;
  }
}

$porciento=($conteo/$limite_permitido)*100;
$porciento=round($porciento,2).'%';

$cadenaActualiza="UPDATE covid_conteo_clientes SET CONTEO_CLIENTES = '$conteo' WHERE SUCURSAL='$sucursal'";
$actualizaConteo=mysqli_query($conexion,$cadenaActualiza);

array_push($conteo_,array(
  'conteo'=>$porciento
));
echo utf8_encode(json_encode($conteo_));

?>