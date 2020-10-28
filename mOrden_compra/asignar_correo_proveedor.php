<?php
include '../global_seguridad/verificar_sesion.php';

date_default_timezone_set('America/Monterrey');
$fecha = date('Y-m-d');
$hora = date('H:i:s');

$cve_prov = $_POST['cv_prov'];
$correo_e = $_POST['correo_e'];
$cadena_comparativo = "lamisionsuper.com";
$coincidencia = strpos($correo_e, $cadena_comparativo);

if($coincidencia==true){
    echo "no_permitido";
}else{
    $cadena_correo = "UPDATE proveedores SET correo_vendedor = '$correo_e' WHERE numero_proveedor = '$cve_prov'";
    $consulta_correo = mysqli_query($conexion, $cadena_correo);

    echo "ok";
}
?>