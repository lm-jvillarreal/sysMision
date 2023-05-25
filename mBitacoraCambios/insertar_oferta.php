<?php
include '../global_seguridad/verificar_sesion.php';

$tipo = $_POST['tipo'];
$folio = $_POST['folio'];
$descripcion = $_POST['descripcion'];
$fecha_mov = $_POST['fecha_mov'];
$encargado = $_POST['encargado'];
$auxiliar = $_POST['auxiliar'];
$no_aplica = $_POST['no_aplica'];

date_default_timezone_set('America/Monterrey');
$fecha_a = date('Y-m-d');
$hora_a = date('H:i:s');
$datetime_a = date('Y-m-d H:i:s');

$cadena_valida = "SELECT id FROM bitacora_cambios WHERE tipo = '$tipo' AND folio='$folio' AND sucursal = '$id_sede'";
$consulta_valida = mysqli_query($conexion, $cadena_valida);
$row_valida = mysqli_fetch_array($consulta_valida);
$conteo = count($row_valida);
if($conteo==0){
    $cadena_insertar = "INSERT INTO bitacora_cambios(tipo, folio, descripcion, fecha_movimiento, usuario_captura, usuario_encargado, fecha_captura, fecha, hora, activo, usuario, sucursal, liberado, nombre_encargado, no_aplica)VALUES('$tipo', '$folio', '$descripcion', '$fecha_mov', '$id_usuario', '$encargado', '$datetime_a', '$fecha_a', '$hora_a', '1', '$id_usuario', '$id_sede', '0', '$auxiliar','$no_aplica')";
    $inserta_registro = mysqli_query($conexion, $cadena_insertar);
    echo "ok";
}else{
    echo "repetido";
}
?>