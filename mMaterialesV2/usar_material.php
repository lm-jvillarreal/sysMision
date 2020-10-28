<?php
    include '../global_seguridad/verificar_sesion.php';

    $material = $_POST['material'];
    $cantidad = $_POST['cantidad'];

    $cadena = mysqli_query($conexion,"UPDATE catalogo_materiales2 SET existencia = existencia - '$cantidad' WHERE id = '$material'");
    $cadena3 = mysqli_query($conexion,"INSERT INTO materiales_movimientos (id_material, id_pedido, tipo, cantidad, fecha, hora, id_usuario) VALUES('$material','100000001','1','$cantidad','$fecha','$hora','$id_usuario')");
    echo "ok";
?>