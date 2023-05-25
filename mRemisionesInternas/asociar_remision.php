<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';
$fechahora=date("Y-m-d H:i:s");
$id_remision=$_POST['id_remision'];
$tipo_movimiento =$_POST['tipo_movimiento'];
$folio_movimiento=$_POST['folio_movimiento'];

$cadenaValidar = "SELECT * FROM INV_MOVIMIENTOS WHERE ALMN_ALMACEN='$id_sede' AND MODC_TIPOMOV='$tipo_movimiento' AND MODN_FOLIO='$folio_movimiento'";
$consulta_validar = oci_parse($conexion_central, $cadenaValidar);
                    oci_execute($consulta_validar);
$row_validar = oci_fetch_row($consulta_validar);
$conteo=count($row_validar[0]);
//echo $cadenaValidar;
if($conteo==0){
  echo "no_existe";
}else{
  $cadenaAsociar="UPDATE inv_remisiones SET ESTATUS_REMISION='2',USUARIO_ASOCIA='$id_usuario',FECHAHORA_ASOCIA='$fechahora',TIPO_MOVIMIENTO='$tipo_movimiento',FOLIO_MOVIMIENTO='$folio_movimiento' WHERE ID='$id_remision'";
  $asociar=mysqli_query($conexion,$cadenaAsociar);

  //Consulta de datos
$consulta_remision = mysqli_query($conexion,"SELECT PREFIJO_REMISION, CONSECUTIVO_REMISION FROM inv_remisiones WHERE id ='$id_remision'");
$row = mysqli_fetch_array($consulta_remision);
$title = $row[0].$row[1];
$consutla_calendario = mysqli_query($conexion,"SELECT folio FROM agenda WHERE title LIKE '%$title%'");
$row2 = mysqli_fetch_array($consutla_calendario);
$eliminar_evento = mysqli_query($conexion,"DELETE FROM agenda WHERE folio = '$row2[0]'");
  echo "ok";
}

?>