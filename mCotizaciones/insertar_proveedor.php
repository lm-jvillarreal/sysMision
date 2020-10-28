<?php
	include '../global_seguridad/verificar_sesion.php';

    $id_proveedor            = $_POST['id_proveedor'];
    $tipo                    = $_POST['tipo'];
    $nombre_proveedor        = $_POST['nombre_proveedor'];
    $id_cotizacion_proveedor = $_POST['id_cotizacion_proveedor'];
    if(isset($_POST['proveedor'])){
        $proveedor = $_POST['proveedor'];
    }else{
        $proveedor = "";
    }
    $fecha_entrega           = $_POST['fecha_entrega'];
    $plazo_dias              = $_POST['plazo_dias'];
    $descuento               = $_POST['descuento'];
    $garantias               = $_POST['garantias'];

    if($tipo == 1){
        if($nombre_proveedor == ""){
            echo "vacio";
            return false;
        }
    }else{
        if($proveedor == ""){
            echo "vacio";
            return false;
        }
    }

    if($id_cotizacion_proveedor == "" || $fecha_entrega == "" || $plazo_dias == "" || $descuento == ""){
        echo "vacio";
        return false;
    }
    

    if ($id_proveedor == "0"){
        $cadena = mysqli_query($conexion,"INSERT INTO proveedores_cotizacion (tipo, nombre_proveedor, id_cotizacion, proveedor, fecha_entrega, plazo_dias, descuento, garantias, fecha, hora, activo, id_usuario) VALUES ('$tipo','$nombre_proveedor','$id_cotizacion_proveedor','$proveedor','$fecha_entrega','$plazo_dias','$descuento','$garantias','$fecha','$hora','1','$id_usuario')");

        if(!empty($_FILES['documento']['name'])){
            $cadena = mysqli_query($conexion,"SELECT MAX(id) FROM proveedores_cotizacion");
            $row = mysqli_fetch_array($cadena);

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
            $cadena2 = mysqli_query($conexion,"UPDATE proveedores_cotizacion SET ruta = '$destino' WHERE id = '$row[0]'");
        }
        echo "ok";
    }else{
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

            $destino =  "documentos/".$id_proveedor.$formato;
            if (copy($_FILES['documento']['tmp_name'],$destino)) {} 
            else {
                $status = "Error al subir el archivo";
            }
            $cadena2 = mysqli_query($conexion,"UPDATE proveedores_cotizacion SET ruta = '$destino' WHERE id = '$id_proveedor'");
        }

        $cadena_act = mysqli_query($conexion,"UPDATE proveedores_cotizacion SET tipo = '$tipo', nombre_proveedor = '$nombre_proveedor', proveedor = '$proveedor', fecha_entrega = '$fecha_entrega', plazo_dias = '$plazo_dias', descuento = '$descuento', garantias = '$garantias', fecha = '$fecha', hora = '$hora', id_usuario = '$id_usuario'  WHERE id = '$id_proveedor'");
        echo "ok";
    }    
?>
