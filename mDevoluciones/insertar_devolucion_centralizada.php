<?php
	include "../global_seguridad/verificar_sesion.php";
    $folio = $_POST['folio'];
    $sucursal = $_POST['sucursal'];
    $proveedor = $_POST['proveedor'];
    $tipo = "DEVCTR";
   
	date_default_timezone_set('America/Monterrey');
	$fecha=date('Y-m-d');
	$hora = date('H:i:s');

    $cadena_validar = "SELECT * FROM devoluciones WHERE folio = '$folio' AND id_sucursal = '$sucursal' AND tipo = '$tipo'";
    $consulta_validar = mysqli_query($conexion, $cadena_validar);
    $conteo = mysqli_num_rows($consulta_validar);

    if ($conteo>0) {
        echo "repetido";
    }elseif($conteo==0){
    	$cadena_insertar= "INSERT INTO devoluciones (id_sucursal, folio, numero_proveedor, fecha, hora, STATUS, usuario_autoriza, tipo)
                    VALUES('$sucursal', '$folio', '$proveedor', '$fecha', '$hora', '0', '$id_usuario', '$tipo')";

    	$consulta_insertar=mysqli_query($conexion,$cadena_insertar);
        echo "ok";
    }
	
?>