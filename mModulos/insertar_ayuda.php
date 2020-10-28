<?php
include '../global_seguridad/verificar_sesion.php';

$ayuda     = $_POST['ayuda'];
$id_modulo = $_POST['modulo'];

if(!empty($_FILES['manual']['name'])){
	
	$tamano  = $_FILES["manual"]['size'];
	$tipo    = $_FILES["manual"]['type'];
	$archivo = $_FILES["manual"]['name'];

	$destino =  "manuales/".$id_modulo.".pdf";
	if (copy($_FILES['manual']['tmp_name'],$destino)) {
		$status = "Archivo subido: <b>".$archivo."</b>";
	}else{
        $status = "Error al subir el archivo";
    }

    $cadena = mysqli_query($conexion,"UPDATE modulos SET ruta_manual = '$destino' WHERE id = '$id_modulo'");
}

$cadena = mysqli_query($conexion,"UPDATE modulos SET ayuda_modulo = '$ayuda' WHERE id = '$id_modulo'");
echo "ok";
?>
