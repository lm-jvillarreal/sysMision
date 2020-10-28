<?php
include '../global_seguridad/verificar_sesion.php';

//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d");
$hora=date ("h:i:s");

$id_gasto = $_POST['id_gasto'];
$fecha_pago = $_POST['fecha_pago'];
$tipo_pago = $_POST['tipo_pago'];
$no_comprobante = $_POST['no_comprobante'];
$observacion = $_POST['observacion'];

$f_nombre = $_FILES["archivos"]['name'];
$f_tamano = $_FILES["archivos"]['size']; 
$f_tipo = $_FILES["archivos"]['type'];

$extension = end(explode(".", $_FILES['archivos']['name']));

$cadena_actualizar = "UPDATE gastos_aportaciones SET fecha_pago = '$fecha_pago', tipo_pago = '$tipo_pago', no_comprobante = '$no_comprobante', estatus = '2', comentarios = '$observacion' WHERE id = '$id_gasto'";
$insertar_gasto = mysqli_query($conexion, $cadena_actualizar);

if ($f_nombre != "") 
	{ 
	    $destino =  "comprobantes/". $id_gasto.".".$extension; 
	        if (copy($_FILES['archivos']['tmp_name'],$destino))  
	        { 
	            $status = "Archivo subido"; 
	        }  
	        else  
	        { 
	            $status = "Error al subir el archivo"; 
	        } 
	}
echo "ok";
?>