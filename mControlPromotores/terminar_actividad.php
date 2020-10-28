<?php
	include '../global_seguridad/verificar_sesion.php';
	//Fecha y hora actual
	date_default_timezone_set('America/Monterrey');
	$fecha=date("Y-m-d"); 
	$hora=date ("H:i:s");

	

	$comentario    = $_POST['comentario'];
	if(isset($_POST['cajas'])){
		$cajas = $_POST['cajas'];
		$cajas_consulta = ",cajas_surtidas = '$cajas'";
	}else{
		$cajas_consulta = "";
	}
	$id_actividad = $_POST['id_actividad_modal'];

	$cadena = mysqli_query($conexion,"SELECT id FROM registro_actividades WHERE id_actividad = '$id_actividad' AND fecha = '$fecha'");
	$row = mysqli_fetch_array($cadena);

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

        $destino =  "evidencia/ev_".$row[0].$formato;
        if (copy($_FILES['documento']['tmp_name'],$destino)) {} 
        else {
            $status = "Error al subir el archivo";
        }
        $cadena2 = mysqli_query($conexion,"UPDATE registro_actividades SET foto = '$destino' WHERE id = '$row[0]'");
    }

    $actualizar = mysqli_query($conexion,"UPDATE registro_actividades SET comentario = '$comentario'".$cajas_consulta." WHERE id = '$row[0]'");
    echo "ok";
	
?>