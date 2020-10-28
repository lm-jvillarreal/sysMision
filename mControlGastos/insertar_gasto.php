<?php
	include '../global_seguridad/verificar_sesion.php';

	$concepto = $_POST['concepto'];
	$monto    = $_POST['monto'];
	$rublo    = $_POST['rublo'];
	$rancho   = $_POST['rancho'];
	$id_gasto = $_POST['id_gasto'];


	if($id_gasto == 0){
		$cadena = mysqli_query($conexion,"INSERT INTO gastos (concepto, monto, id_rublo, id_rancho, fecha, hora, activo, id_usuario) VALUES ('$concepto','$monto','$rublo','$rancho','$fecha','$hora','1','$id_usuario')");
		if(!empty($_FILES['archivo']['name'])){
            $cadena1 = mysqli_query($conexion,"SELECT MAX(id) FROM gastos");
            $row = mysqli_fetch_array($cadena1);

            $tamano  = $_FILES["archivo"]['size'];
            $tipo    = $_FILES["archivo"]['type'];
            $archivo = $_FILES["archivo"]['name'];

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

            $destino =  "facturas/".$row[0].$formato;
            if (copy($_FILES['archivo']['tmp_name'],$destino)){} 
            else {
                $status = "Error al subir el archivo";
            }
        }

	}else{
		$cadena = mysqli_query($conexion,"UPDATE gastos SET concepto = '$concepto', monto = '$monto', id_rublo = '$rublo', id_rancho = '$rancho', fecha = '$fecha', hora = '$hora', id_usuario = '$id_usuario' WHERE id = '$id_gasto'");

		if(!empty($_FILES['archivo']['name'])){
            $tamano  = $_FILES["archivo"]['size'];
            $tipo    = $_FILES["archivo"]['type'];
            $archivo = $_FILES["archivo"]['name'];

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

            $destino =  "facturas/".$id_gasto.$formato;
            if (copy($_FILES['archivo']['tmp_name'],$destino)){} 
            else {
                $status = "Error al subir el archivo";
            }
        }
	} 	
	echo "ok";
?>