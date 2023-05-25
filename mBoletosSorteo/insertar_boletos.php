<?php
include '../global_seguridad/verificar_sesion.php';

$prefijo = $_POST['prefijo'];
$consecutivo = $_POST['consecutivo'];
$total = $_POST['total'];
$cantidad_boletos = $_POST['cantidad_boletos'];
$restantes = $_POST['restantes'];
$folio_ticket=$prefijo.$consecutivo;

$cadenaValidar="SELECT * FROM registro_boletos2 WHERE folio_ticket='$folio_ticket' AND usuario='$id_usuario'";
$consultaValidar=mysqli_query($conexion,$cadenaValidar);
$rowValidar=mysqli_fetch_array($consultaValidar);
$conteoValidar=count($rowValidar[0]);
if($conteoValidar>0){
  echo "ya_existe";
}else{
  $cadenaMinimo="SELECT MIN(folio_boleto) FROM registro_boletos2 WHERE estatus='1' AND usuario='$id_usuario' AND sucursal='$id_sede'";
  $consultaMinimo=mysqli_query($conexion,$cadenaMinimo);
  $rowMinimo=mysqli_fetch_array($consultaMinimo);
  if(is_null($rowMinimo[0])){
    echo "no_folios";
  }else{
    $limite=$rowMinimo[0]+$cantidad_boletos;
    for($i=$rowMinimo[0];$i<$limite;){
      $cadenaUpdate="UPDATE registro_boletos2 SET estatus='2', folio_ticket='$folio_ticket', total='$total' WHERE folio_boleto='$i' AND usuario='$id_usuario'";
      $consultaUpdate=mysqli_query($conexion,$cadenaUpdate);
      $i=$i+1;
    }
    echo "ok";
  }
}
?>