<?php
	include '../global_seguridad/verificar_sesion.php';

	$id_pieza = $_POST['id_pieza'];
    $cantidad = $_POST['cantidad'];
    $folio = $_POST['folio'];

    $cadena = mysqli_query($conexion,"INSERT INTO historial_prestamos (id_prestamo, codigo_interno, cantidad, activo, fecha, hora, id_usuario) VALUES('$folio','$id_pieza','$cantidad','1','$fecha','$hora','$id_usuario')");

    //ID_SUCURSAL MANUAL//////
//     $consulta=mysqli_query($conexion, "SELECT cantidad, codigo_interno, id_almacen
//             FROM historial_existencias
// 			WHERE codigo_interno = '$id_pieza' 
//             AND id_almacen = '2'");   
//     while($row=mysqli_fetch_row($consulta)){
//         $Rcantidad2 = $row[0];        
//     }
//    $actCant2 = $Rcantidad2 - $cantidad;
    
    $consulta3="UPDATE historial_existencias
                SET cantidad = cantidad - '$cantidad'
                WHERE
                codigo_interno = '$id_pieza' 
                AND id_almacen = '2'";             
    $result = mysqli_query($conexion, $consulta3); 

    echo "ok";
?>
