<?php
	include '../global_seguridad/verificar_sesion.php';

	$folio = $_POST['folio'];
	$parte = $_POST['parte'];
    $descripcion = $_POST['descripcion'];
    $cantidad = $_POST['cantidad'];
    $costo = $_POST['costo'];
    $u_costo = $_POST['u_costo'];
    $id_sucursal = $_POST['id_sucursal'];
    $id_registro2 = $_POST['id_registro2'];

	if($id_registro2 == 0){
        $cadena_orden = mysqli_query($conexion,"SELECT orden_compra FROM entradas WHERE folio = '$folio'");
        $row = mysqli_fetch_array($cadena_orden);

        $cadena = mysqli_query($conexion,"INSERT INTO historial_entradas (folio, orden_compra, codigo_interno,costo_pza, ult_costo, cantidad, id_almacen, activo, fecha) VALUES('$folio','$row[0]','$parte', '$costo','$u_costo','$cantidad','$id_sucursal','1','$fecha')");

        $consulta4="UPDATE catalogo_piezas SET ult_costo_pza = '$u_costo' WHERE codigo_interno = '$parte'";
                                
        $result4 = mysqli_query($conexion, $consulta4); 

        // actualizar datos ______________________________________________________________
        $consulta=mysqli_query($conexion, "SELECT cantidad, codigo_interno
                    FROM historial_existencias
                    where codigo_interno = '$parte' AND id_almacen = '$id_sucursal'");   
        while($row=mysqli_fetch_row($consulta)){
            $Rcantidad = $row[0];        
        }
        $actCant = $cantidad+$Rcantidad;
            
        $consulta3="UPDATE historial_existencias 
                    SET 
                    cantidad =  '$actCant',
                    ult_costo =  '$u_costo'
                    WHERE 
                    codigo_interno = '$parte'
                    AND id_almacen = '$id_sucursal'";   
                                        
        $result = mysqli_query($conexion, $consulta3);
        echo "ok";
	}
?>
