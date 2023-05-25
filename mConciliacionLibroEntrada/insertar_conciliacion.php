<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set("America/Monterrey");
$fecha=date("Y-m-d H:i:s");

$ficha_entrada = $_POST['ficha_entrada'];
$clave_proveedor = $_POST['clave_proveedor'];
$nombre_proveedor = $_POST['nombre_proveedor'];
$remision = $_POST['remision'];
$total_remision = $_POST['total_remision'];
$total_entrada = $_POST['total_entrada'];
$total_devoluciones = $_POST['total_devoluciones'];
$total_cf = $_POST['total_cf'];
$total_dc = $_POST['total_dc'];
$total_dc2 = $_POST['total_dc2'];
$gran_total = $_POST['gran_total'];
$diferencia = $_POST['diferencia'];
$escaneada = $_POST['escaneada'];

$cadenaValidar = "SELECT id FROM alb_resumenEntradas WHERE ficha_entrada = '$ficha_entrada'";
$consultaValidar = mysqli_query($conexion, $cadenaValidar);
$rowValidar = mysqli_fetch_array($consultaValidar);
$conteo = count($rowValidar[0]);
if($conteo>0){
  $cadenaInsertar = "UPDATE alb_resumenEntradas SET cve_proveedor = '$clave_proveedor', proveedor='$nombre_proveedor', remision='$remision',total_remision='$total_remision', total_entrada='$total_entrada', total_devoluciones='$total_devoluciones', total_cf='$total_cf', total_dc='$total_dc', total_dc2='$total_dc2', gran_total='$gran_total', diferencia='$diferencia', fecha='$fecha', activo='1', usuario='$id_usuario', escaneada='$escaneada' WHERE ficha_entrada = '$ficha_entrada'";
  //echo $cadenaInsertar;
}else{
  $cadenaInsertar = "INSERT INTO alb_resumenEntradas (ficha_entrada, cve_proveedor, proveedor, remision, total_remision, total_entrada, total_devoluciones, total_cf, total_dc, total_dc2, gran_total, diferencia, fecha, activo, usuario, escaneada)VALUES('$ficha_entrada','$clave_proveedor','$nombre_proveedor','$remision','$total_remision','$total_entrada','$total_devoluciones','$total_cf','$total_dc','$total_dc2','$gran_total','$diferencia','$fecha','1','$id_usuario','$escaneada')";
}
$insertarResumen = mysqli_query($conexion, $cadenaInsertar);
echo "ok";
?>