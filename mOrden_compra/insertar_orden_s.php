<?php 
	include '../global_seguridad/verificar_sesion.php';
	include 'funciones.php';

	date_default_timezone_set('America/Monterrey');
    $fecha = date('Y-m-d');
    $hora = date('H:i:s');

	$cve_proveedor = $_POST['cve_proveedor'];
	$sucursal = $_POST['suc'];
	$fecha_llegada = $_POST['fecha_llegada_s'];
	$comentarios = $_POST['coment'];

	$inicio = _formatear($fecha_llegada . "08:00");
  $final  = _formatear($fecha_llegada . "08:00");
	$cant_sucursales = count($sucursal);

	$f_nombre = $_FILES["archivos"]['name'];
	$f_tamano = $_FILES["archivos"]['size']; 
	$f_tipo = $_FILES["archivos"]['type'];

	$extension = end(explode(".", $_FILES['archivos']['name']));


	for ($i=0; $i < $cant_sucursales; $i++) { 

		if ($sucursal[$i] == 1 ) {
	        $clase = "event-important";
	        $suc = '1';//DO
	    }elseif ($sucursal[$i] == 2) {
	        $clase = "event-success";
	        $suc = '2';//Arboledas
	    }elseif($sucursal[$i] == 3){
	        $clase = "event-info";
	        $suc = '3'; //Villegas
	    }elseif($sucursal[$i] == 4){
	        $clase = "event-special";
	        $suc = '4'; //Allende
	    }

		$cadena_entsoc = "SELECT orden_compra, id FROM orden_compra WHERE tipo = '2' ORDER BY id DESC LIMIT 1";
		$consulta_entsoc = mysqli_query($conexion, $cadena_entsoc);
		$row_entsoc = mysqli_fetch_array($consulta_entsoc);
		$id_entsoc = $row_entsoc[0]+1;

		$cadena_inserta = "INSERT INTO orden_compra (id_proveedor, id_sucursal, orden_compra, fecha_llegada, fecha, hora, activo, usuario, comentarios, tipo, status, recibido, completo)VALUES('$cve_proveedor','$sucursal[$i]','$id_entsoc','$fecha_llegada','$fecha','$hora','1','$id_usuario','$comentarios','2', '2', '0', '0')";
		$insertar_entsoc = mysqli_query($conexion, $cadena_inserta);

		$cadena_prov = "SELECT proveedor FROM proveedores where numero_proveedor = '$cve_proveedor'";
		$consulta_prov = mysqli_query($conexion, $cadena_prov);
		$row_prov = mysqli_fetch_array($consulta_prov);

		$cadena_evento  = "INSERT INTO eventos VALUES(null,'$row_prov[0]','$id_entsoc','','$clase','$inicio','$final','$fecha_llegada','$fecha_llegada', '$sucursal[$i]')";
		$insertar_evento = mysqli_query($conexion, $cadena_evento);

		if ($f_nombre != "") 
        { 
            $destino =  "docs/". $id_entsoc.".".$extension; 
                if (copy($_FILES['archivos']['tmp_name'],$destino))  
                { 
                    $status = "Archivo subido"; 
                }  
                else  
                { 
                    $status = "Error al subir el archivo"; 
                } 
        }
	}
	echo "ok";
 ?>