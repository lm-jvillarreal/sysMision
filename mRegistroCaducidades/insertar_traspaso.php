<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("h:i:s");

$ide = $_POST['ide'];
$suc = $_POST['ide'];
$max = $_POST['max'];
$cantidad = $_POST['cantidad'];

if($cantidad>$max){
    echo "excedido";
}else{
    $resto = $max - $cantidad;
    $cadena_buscar = "SELECT id, codigo_articulo, descripcion_articulo, precio_publico, precio_oferta, cantidad, fecha_caducidad, sucursal, lote, estatus FROM far_medicamentosCaducan WHERE id = '$ide'";
    $consulta_buscar = mysqli_query($conexion, $cadena_buscar);
    $row_buscar = mysqli_fetch_array($consulta_buscar);

    $cadena_descuenta = "UPDATE far_medicamentosCaducan SET cantidad = '$resto' WHERE id = '$ide'";
    $consulta_descuenta = mysqli_query($conexion, $cadena_descuenta);

    $cadena_inserta = "INSERT INTO far_medicamentosCaducan (codigo_articulo, 
                                                            descripcion_articulo, 
                                                            precio_publico, 
                                                            precio_oferta, 
                                                            cantidad, 
                                                            fecha_caducidad, 
                                                            sucursal, 
                                                            lote, 
                                                            estatus)
                                                            VALUES('$row_buscar[1]',
                                                                    '$row_buscar[2]',
                                                                    '$row_buscar[3]',
                                                                    '$row_buscar[4]',
                                                                    '$row_buscar[5]',
                                                                    '$row_buscar[6]',
                                                                    '$id_sede',
                                                                    '$row_buscar[8]',
                                                                    '$row_buscar[9]')";
    $inserta_traspaso = mysqli_query($conexion, $cadena_inserta);

    $cadena_historial="INSERT INTO far_traspasos (id_caducidad, codigo, cantidad, sucursal_destino, fecha, hora, activo, usuario)VALUES('$ide', '$row_buscar[1]', '$cantidad', '$id_sede', '$fecha', '$hora', '1', '$id_usuario')";
    $inserta_historial = mysqli_query($conexion, $cadena_historial);
    echo $cadena_buscar;
}
?>