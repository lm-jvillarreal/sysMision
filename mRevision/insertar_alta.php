<?php
	include '../global_seguridad/verificar_sesion.php';
	date_default_timezone_set('America/Monterrey');
	$fecha = date('Y-m-d');
	$hora  = date('H:i:s');

	$proveedor = $_POST['proveedor'];
	$comprador = $_POST['comprador'];
	$costo     = $_POST['costo'];
	$ieps      = 0;
	$iva       = 0;

	if(isset($_POST['impuesto'])){
		$impuesto  = $_POST['impuesto'];
		if(!empty($_POST['impuesto'])){
			$impuesto           = $_POST['impuesto'];
			if(!empty($impuesto[0])){
				if ($impuesto[0] == 1){
					$iva = 1;
				}
				else if($impuesto[0] == 2){
					$ieps = 2;
				}
			}
			if(!empty($impuesto[1])){
				if ($impuesto[1] == 1){
					$iva = 1;
				}
				else if($impuesto[1] == 2){
					$ieps = 2;
				}
			}
		}
	}	
  	if(!empty($_POST['id_registro'])){
  		$id_registro = $_POST['id_registro'];


  		if(!empty($_FILES['IP']['name'])){
  			$tamano  = $_FILES["IP"]['size'];
			$tipo    = $_FILES["IP"]['type'];
			$archivo = $_FILES["IP"]['name'];
			$prefijo = "P";

			$destinoP =  "imagenes/".$id_registro.$prefijo.".jpg";
			if (copy($_FILES['IP']['tmp_name'],$destinoP)) 
	        {
	            $status = "Archivo subido: <b>".$archivo."</b>";
	        } 
	        else 
	        {
	            $status = "Error al subir el archivo";
	        }

	        $cadena = mysqli_query($conexion,"UPDATE altas_productos SET img_presentacion = '$destinoP' WHERE id = '$id_registro'");
  		}

  		if(!empty($_FILES['IC']['name'])){
  			$tamano1  = $_FILES["IC"]['size'];
			$tipo1    = $_FILES["IC"]['type'];
			$archivo1 = $_FILES["IC"]['name'];
			$prefijo1  = "C";

	        $destinoC =  "imagenes/".$id_registro.$prefijo1.".jpg";
			if (copy($_FILES['IC']['tmp_name'],$destinoC)) 
	        {
	            $status = "Archivo subido: <b>".$archivo1."</b>";
	        } 
	        else 
	        {
	            $status = "Error al subir el archivo";
	        }
	        $cadena = mysqli_query($conexion,"UPDATE altas_productos SET img_codigo = '$destinoC' WHERE id = '$id_registro'");
  		}

		$consultar_impuestos = mysqli_query($conexion,"SELECT iva,ieps FROM altas_productos WHERE id = '$id_registro'");
		$row_impuestos       = mysqli_fetch_array($consultar_impuestos);

		if($row_impuestos[0] == $iva){
			$cadena_iva = "";
		}
		else{
			$cadena_iva = ",iva = '$iva'";
		}
		if($row_impuestos[1] == $ieps){
			$cadena_ieps = "";
		}
		else{
			$cadena_ieps = ",ieps = '$ieps'";
		}

  		$cadena_actualizar = mysqli_query($conexion,"UPDATE altas_productos SET id_comprador = '$comprador', id_proveedor = '$proveedor', costo = '$costo '".$cadena_iva.' '.$cadena_ieps." WHERE id = '$id_registro'");

  		echo "ok";
  	}
  	else{
		$cadena_folio = mysqli_query($conexion,"SELECT MAX(folio) FROM altas_productos");
		$row_folio    = mysqli_fetch_array($cadena_folio);
		if($row_folio[0] == ""){
			$folio = 1;
		}
		else{
			$folio = $row_folio[0] + 1;
		}

		$cadena = mysqli_query($conexion,"INSERT altas_productos (id_proveedor,id_comprador,folio,costo,iva,ieps,estatus,fecha,hora,id_usuario,activo,id_sucursal)
					VALUES('$proveedor','$comprador','$folio','$costo','$iva','$ieps','0','$fecha','$hora','$id_usuario','1','$id_sede')");
		echo "ok";
  	}
 ?>