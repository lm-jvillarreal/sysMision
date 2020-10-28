<?php
include '../global_seguridad/verificar_sesion.php';

$cadenaAviso="SELECT 
                ID, 
                TITULO_AVISO, 
                DETALLE_AVISO, 
                ID_PERFIL, 
                USUARIO_VISUALIZA, 
                FECHAHORA_VIGENCIA, 
                CANTIDAD_APARICIONES, 
                IFNULL(CONTEO_APARICIONES,0), 
                FECHAHORA, 
                ACTIVO, 
                USUARIO_REGISTRA 
              FROM global_avisos 
              WHERE USUARIO_VISUALIZA='$id_usuario' 
              AND ACTIVO='1' 
              AND Date_Format(curdate(), '%Y-%m-%d') <= DATE_FORMAT(FECHAHORA_VIGENCIA,'%Y-%m-%d')";

$consultaAviso=mysqli_query($conexion,$cadenaAviso);
$rowAviso=mysqli_fetch_array($consultaAviso);
$datos=array();
$conteo=count($rowAviso[0]);
if($conteo==0){
 array_push($datos,array(
  'existe'=>'NO',
  'nombre_persona'=>'',
  'titulo'=>'',
  'detalle'=>''
 ));
}elseif($conteo>0 && $rowAviso[7]<$rowAviso[6]){
  $cantidadConteo=$rowAviso[7]+1;
  $cadenaConteo="UPDATE global_avisos SET CONTEO_APARICIONES='$cantidadConteo' WHERE ID='$rowAviso[0]'";
  $actualizaConteo=mysqli_query($conexion,$cadenaConteo);

  array_push($datos,array(
    'existe'=>'SI',
    'nombre_persona'=>$nombre_persona,
    'titulo'=>$rowAviso[1],
    'detalle'=>$rowAviso[2]
   ));
}
$array_datos=json_encode($datos);
echo $array_datos;
?>