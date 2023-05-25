<?php
	include '../global_seguridad/verificar_sesion.php';
	//Fecha y hora actual
	date_default_timezone_set('America/Monterrey');
	$fecha=date("Y-m-d"); 
	$hora=date ("h:i:s");

    $gasto_id      = $_POST['id_gasto'];
    $proveedor     = $_POST['proveedor'];
    $fecha_mov     = $_POST['fecha_mov'];
    $gasto         = $_POST['gasto'];
    $rublo         = $_POST['rublo'];
    $comentario    = $_POST['comentario'];
    $folio_factura = $_POST['folio_factura'];
    $sucursal      = $_POST['sucursal'];

    $fecha_mov = substr($fecha_mov, 0, 10);
    if ($gasto_id == "0"){
        $cadena = "INSERT INTO gastos_sistemas (proveedor,fecha_movimiento,gasto,id_rublo,documento,comentario,folio_factura,
                fecha,hora,activo,id_usuario,id_sucursal)
        VALUES ('$proveedor','$fecha_mov','$gasto','$rublo','','$comentario','$folio_factura','$fecha','$hora','1','$id_usuario','$sucursal')";
        $inserta= mysqli_query($conexion,$cadena);

// $cadena = mysqli_query($conexion,"INSERT INTO gastos_sistemas (proveedor,fecha_movimiento,gasto,id_rublo,documento,comentario,folio_factura,
//                 fecha,hora,activo,id_usuario,id_sucursal)
//         VALUES ('$proveedor','$fecha_mov','$gasto','$rublo','','$comentario','$folio_factura','$fecha','$hora','1','$id_usuario','$sucursal')");

        if(!empty($_FILES['documento']['name'])){
            $cadena1 = mysqli_query($conexion,"SELECT MAX(id) FROM gastos_sistemas");
            $row = mysqli_fetch_array($cadena1);

            $tamano  = $_FILES["documento"]['size'];
            $tipo    = $_FILES["documento"]['type'];
            $archivo = $_FILES["documento"]['name'];

            if ($tipo == "image/jpeg" ){
                $formato = ".jpg";
            }else if($tipo == "image/png"){  
                $formato = ".png";
            }else if($tipo == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"){
                $formato = ".xlsx";
            }else if($tipo == "application/vnd.openxmlformats-officedocument.wordprocessingml.document"){
                $formato = ".docx";
            }else if($tipo == "application/vnd.openxmlformats-officedocument.presentationml.presentation"){
                $formato = ".pptx";
            }else if($tipo == "application/pdf"){
                $formato = ".pdf";
            }

            $destino =  "documentos/".$row[0].$formato;
            if (copy($_FILES['documento']['tmp_name'],$destino)) {} 
            else {
                $status = "Error al subir el archivo";
            }
            $cadena2 = mysqli_query($conexion,"UPDATE gastos_sistemas SET documento = '$destino' WHERE id = '$row[0]'");
        }
        echo "ok";
    }else{
        if(!empty($_FILES['imagen']['name'])){

            $tamano  = $_FILES["imagen"]['size'];
            $tipo    = $_FILES["imagen"]['type'];
            $archivo = $_FILES["imagen"]['name'];

            if ($tipo == "image/jpeg" ){
                $formato = ".jpg";
            }else if($tipo == "image/png"){  
                $formato = ".png";
            }else if($tipo == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"){
                $formato = ".xlsx";
            }else if($tipo == "application/vnd.openxmlformats-officedocument.wordprocessingml.document"){
                $formato = ".docx";
            }else if($tipo == "application/vnd.openxmlformats-officedocument.presentationml.presentation"){
                $formato = ".pptx";
            }else if($tipo == "application/pdf"){
                $formato = ".pdf";
            }

            $destino =  "documentos/ev_".$gasto_id.$formato;
            if (copy($_FILES['imagen']['tmp_name'],$destino)) {} 
            else {
                $status = "Error al subir el archivo";
            }
            $cadena2 = mysqli_query($conexion,"UPDATE gastos_sistemas SET evidencia = '$destino' WHERE id = '$gasto_id'");
        }
        if(!empty($_FILES['documento']['name'])){

            $tamano  = $_FILES["documento"]['size'];
            $tipo    = $_FILES["documento"]['type'];
            $archivo = $_FILES["documento"]['name'];

            if ($tipo == "image/jpeg" ){
                $formato = ".jpg";
            }else if($tipo == "image/png"){  
                $formato = ".png";
            }else if($tipo == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"){
                $formato = ".xlsx";
            }else if($tipo == "application/vnd.openxmlformats-officedocument.wordprocessingml.document"){
                $formato = ".docx";
            }else if($tipo == "application/vnd.openxmlformats-officedocument.presentationml.presentation"){
                $formato = ".pptx";
            }else if($tipo == "application/pdf"){
                $formato = ".pdf";
            }

            $destino =  "documentos/".$gasto_id.$formato;
            if (copy($_FILES['documento']['tmp_name'],$destino)) {} 
            else {
                $status = "Error al subir el archivo";
            }
            $cadena2 = mysqli_query($conexion,"UPDATE gastos_sistemas SET documento = '$destino' WHERE id = '$gasto_id'");
        }
        $cadena_act = mysqli_query($conexion,"UPDATE gastos_sistemas SET id_rublo = '$rublo', comentario = '$comentario', id_sucursal = '$sucursal' WHERE id = '$gasto_id'");
        echo "ok";
    }    
?>
