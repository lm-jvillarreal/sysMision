<?php
	include '../global_seguridad/verificar_sesion.php';

	$folio = $_POST['folio'];
	$id_sucursal = $_POST['id_sucursal2'];
    $parte = $_POST['parte'];
    $cantidad = $_POST['cantidad'];
    $entrega = $_POST['entrega'];   

    $cadena_orden = mysqli_query($conexion,"SELECT orden_trabajo FROM salidas WHERE folio = '$folio'");
    $row_orden = mysqli_fetch_array($cadena_orden);
    $consulta2="INSERT INTO historial_salidas (folio, orden_trabajo, codigo_interno, cantidad, entrega, fecha,id_almacen) VALUES ('$folio', '$row_orden[0]', '$parte', '$cantidad', '$entrega','$fecha','$id_sucursal')";       
    $result2 = mysqli_query($conexion, $consulta2);

    $consulta3=mysqli_query($conexion, "SELECT cantidad, codigo_interno, id_almacen
                                        FROM historial_existencias
                                        WHERE codigo_interno = '$parte'
                                        AND id_almacen = '$id_sucursal'");

    $row1=mysqli_fetch_row($consulta3);
    $Nueva = $row1[0] - $entrega;
    $consulta1="UPDATE historial_existencias
    SET cantidad = '$Nueva'
    WHERE codigo_interno = '$parte'
    AND id_almacen = '$id_sucursal'";             
    $result1 = mysqli_query($conexion, $consulta1);
    echo "ok";
?>