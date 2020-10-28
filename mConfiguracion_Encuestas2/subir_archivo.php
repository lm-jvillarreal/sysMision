<?php
	if(!empty($_FILES['plantilla']['name'])){
		$tamano  = $_FILES["plantilla"]['size'];
		$tipo    = $_FILES["plantilla"]['type'];
		$archivo = $_FILES["plantilla"]['name'];

		$destino =  "plantilla.xlsx";
		if (copy($_FILES['plantilla']['tmp_name'],$destino)) 
	    {
	        $status = "ok";
	    } 
	    else 
	    {
	        $status = "Error al subir el archivo";
	    }
	}
?>