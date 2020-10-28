<?php
	include '../global_seguridad/verificar_sesion.php';
	//Fecha y hora actual
	date_default_timezone_set('America/Monterrey');
	$fecha=date("Y-m-d"); 
	$hora=date ("H:i:s");

    $id_actividad = $_POST['id_actividad_modal'];
    $comentario   = $_POST['comentario'];

    $cadena = mysqli_query($conexion,"SELECT principal FROM actividades_promotor WHERE id = '$id_actividad'");
    $row = mysqli_fetch_array($cadena);

    if($row[0] == "1"){
        $cajas          = $_POST['caja'];
        if(empty($cajas)){
            echo "vacio";
            return false;
        }else{
            $cajas_consulta = ",cajas_surtidas = '$cajas'";
        }
    }else{
        $cajas_consulta = "";
    }

    $cadena = mysqli_query($conexion,"SELECT id FROM registro_actividades WHERE id_actividad = '$id_actividad' AND fecha = '$fecha' AND id_sucursal = '$id_sede'");
    $row = mysqli_fetch_array($cadena);

    if(!empty($_FILES['documento']['name'])){
        $tamano  = $_FILES["documento"]['size'];
        $tipo    = $_FILES["documento"]['type'];
        $archivo = $_FILES["documento"]['name'];

        $destino =  "evidencia/ev_".$row[0].'.jpg';
        if (copy($_FILES['documento']['tmp_name'],$destino)) {} 
        else {
            $status = "Error al subir el archivo";
        }
        $cadena2 = mysqli_query($conexion,"UPDATE registro_actividades SET foto = '$destino' WHERE id = '$row[0]' AND id_sucursal = '$id_sede'");
    }

    $actualizar = mysqli_query($conexion,"UPDATE registro_actividades SET comentario = '$comentario'".$cajas_consulta." WHERE id = '$row[0]'");
    
    echo "ok";		
?>