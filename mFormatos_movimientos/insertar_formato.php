<?php
include '../global_seguridad/verificar_sesion.php';

$tipo_formato = $_POST['tipo_movimiento'];
$auxiliar = $_POST['auxiliar'];

$nombre_solicita = (empty($auxiliar))?$nombre_persona: $auxiliar;

$cadena_validar = "SELECT * FROM formatos_movimientos WHERE tipo_movimiento = '$tipo_formato' AND  estatus = '0' AND sucursal = '$id_sede'";
$consulta_validar = mysqli_query($conexion, $cadena_validar);
$row_validar = mysqli_fetch_array($consulta_validar);
$conteo = count($row_validar[0]);

if($conteo>0){
    echo "pendiente";
}else{
    $cadena_insertar = "INSERT INTO formatos_movimientos (tipo_movimiento, prefijo_movimiento, sucursal, estatus, fecha, hora, activo, nombre_solicita, nombre_genera)values('$tipo_formato', '', '$id_sede', '0', '$fecha', '$hora', '1', '$nombre_solicita','$id_usuario')";
    $insertar_folio = mysqli_query($conexion, $cadena_insertar);
    //echo $cadena_insertar;
    echo $tipo_formato;
}
?>