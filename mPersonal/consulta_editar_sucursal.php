<?php
include '../global_seguridad/verificar_sesion.php';

$persona = $_POST['persona'];

$cadena_sucursal = "SELECT s.id, 
                           s.nombre,
                           p.nombre,
                           p.ap_paterno,
                           p.ap_materno
                    FROM sucursales as s INNER JOIN personas as p ON s.id = p.id_sede 
                    WHERE p.id = '$persona'";
$consulta_sucursal = mysqli_query($conexion, $cadena_sucursal);

$row_consulta= mysqli_fetch_array($consulta_sucursal);

$array = array(
    $row_consulta[0],
    $row_consulta[1],
    $row_consulta[2],
    $row_consulta[3],
    $row_consulta[4]
);
$array_datos = json_encode($array);
echo $array_datos;
?>