<?php
error_reporting(0);
include '../global_seguridad/verificar_sesion.php';

$fechahora = $fecha.' '.$hora;

$id_evidencia = $_POST['folio'];

$f_nombre = $_FILES["file"]['name'];
$f_tamano = $_FILES["file"]['size']; 
$f_tipo = $_FILES["file"]['type'];

$extension = end(explode(".", $f_nombre));

$cadenaInsertar="INSERT INTO revision_cierre_historial (ID_REVISION_CIERRE, ID_USUARIOREVISA, FECHAHORA_REVISION)VALUES('$id_evidencia','$id_usuario','$fechahora')";
$insertar=mysqli_query($conexion,$cadenaInsertar);

$cadenaId="SELECT IFNULL(MAX(ID),0) FROM revision_cierre_historial";
$consultaId=mysqli_query($conexion,$cadenaId);
$rowId=mysqli_fetch_array($consultaId);
$id_historial=$rowId[0];

if($id_historial>0){
  $destino =  "img/". $id_historial.".".$extension;
  if (copy($_FILES['file']['tmp_name'],$destino))  { 
    $status = "Archivo subido"; 
  }else{ 
    $status = "Error al subir el archivo"; 
  } 
}
echo "ok";
?>