<?php
include '../global_seguridad/verificar_sesion.php';
$id = $_POST['ide_prov'];
$cve_prov = TRIM($_POST['clave_proveedor']);
$nombre_proveedor = $_POST['nombre_proveedor'];
$correo_prov = $_POST['correo_prov'];
$id_comprador = $_POST['id_comprador'];
$tipo_proveedor =$_POST['tipo_proveedor'];
$dificultad=$_POST['dificultad'];

if (empty($id)) {
    $cadena_validar = "SELECT id FROM proveedores WHERE TRIM(numero_proveedor) = '$cve_prov'";
    $consulta_validar = mysqli_query($conexion, $cadena_validar);
    $row_validar = mysqli_fetch_array($consulta_validar);
    $conteo = count($row_validar);
    if($conteo==0){
        $cadena = "INSERT INTO proveedores (numero_proveedor, proveedor, correo_vendedor, id_comprador, tipo_proveedor, dificultad)VALUES('$cve_prov','$nombre_proveedor', '$correo_prov', '$id_comprador','$tipo_proveedor','$dificultad')";
        $respuesta = "ok";
    }else{
        $respuesta = "repetido";
    }
} else {
    $cadena = "UPDATE proveedores SET numero_proveedor = '$cve_prov', proveedor = '$nombre_proveedor', correo_vendedor = '$correo_prov', id_comprador = '$id_comprador', tipo_proveedor='$tipo_proveedor', dificultad='$dificultad' WHERE id = '$id'";
    $respuesta = "ok";
}
$consulta = mysqli_query($conexion, $cadena);
echo $respuesta;
?>