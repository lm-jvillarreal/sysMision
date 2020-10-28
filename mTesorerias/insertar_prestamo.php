<?php
	include '../global_seguridad/verificar_sesion.php';
	date_default_timezone_set('America/Monterrey');
	$fecha = date('Y-m-d');
	$hora  = date('h:i:s');
	$semana = date('W', strtotime('-1 week')) ; // resta 1 semana
	

	$cantidad  = $_POST['cantidad'];
	$morralla  = $_POST['morralla'];
	$resultado = $_POST['resultado'];

	$cant  = count($morralla);
	$folio = 0;

	$cadena_folio = mysqli_query($conexion,"SELECT MAX(folio) FROM prestamos_morralla");
    $row_folio = mysqli_fetch_array($cadena_folio);

    if($row_folio == ""){
    	$folio = 1;
    }
    else{
    	$folio = $row_folio[0] + 1;
    }

    for ($i=0; $i < $cant ; $i++) { 
    	$cadena = mysqli_query($conexion,"INSERT INTO prestamos_morralla (folio,cantidad,morralla,resultado,semana,id_usuario,id_sucursal,fecha,hora,activo)
    		VALUES ('$folio','$cantidad[$i]','$morralla[$i]','$resultado[$i]','$semana','$id_usuario','$id_sede','$fecha','$hora','1')");
    }
    echo "ok";
?>