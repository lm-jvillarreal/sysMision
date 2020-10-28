<?php
include '../global_seguridad/verificar_sesion.php';

$id = $_POST['liberar'];
$conteo = count($id);

date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d H:i:s"); 

for($i=0; $i<$conteo; $i++){
    $cadena_liberar = "UPDATE faltantes_pasven SET estatus = '4', usuario_verifica = '$id_persona', fecha_verifica = '$fecha', comenta_verifica = 'LIBERADO POR OPCION MULTIPLE' WHERE id = '$id[$i]'";
    $consulta_liberar = mysqli_query($conexion, $cadena_liberar);
}
echo "ok";
?>