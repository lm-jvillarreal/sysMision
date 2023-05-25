<?php
include '../global_seguridad/verificar_sesion.php';
//include '../global_settings/conexion.php';
$datos=array();
$cadenaFolios="SELECT id, folio_boleto, folio_ticket, total FROM registro_boletos2 WHERE usuario='$id_usuario' AND fecha='$fecha' AND estatus='1'";
$consultaFolios=mysqli_query($conexion,$cadenaFolios);
while($rowFolios=mysqli_fetch_array($consultaFolios)){
  array_push($datos,array(
    'id'=>$rowFolios[0],
    'folio_boleto'=>$rowFolios[1],
    'folio_ticket'=>$rowFolios[2],
    'total'=>$rowFolios[3]
  ));
}
echo utf8_encode(json_encode($datos));
?>