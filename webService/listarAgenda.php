<?php
include '../global_settings/conexion.php';

$id_usuario1 = $_POST["id_usuario"];
$cadena  = "SELECT title,DATE_FORMAT(start, '%d-%m-%Y'),DATE_FORMAT(end, '%d-%m-%Y'),start,end,id,folio FROM agenda WHERE id_usuario = '$id_usuario1' ORDER BY id DESC";

$consulta = mysqli_query($conexion,$cadena);

$data = array();
while ($row_agenda = mysqli_fetch_array($consulta)) {
  array_push($data,array(
    "titulo" => $row_agenda[0],
    "fecha_inicio" => $row_agenda[1],
    "fecha_fin" => $row_agenda[2]
  ));
}
echo utf8_encode(json_encode($data));
//error_reporting(0);
/*include '../../global_settings/conexion.php';
date_default_timezone_set('America/Monterrey');
$imagen = base64_decode($_POST["imagen"]);
$id_evidencia = $_POST['folio'];
$id_usuario = $_POST["id_usuario"];
$nombre = $_POST["nombre"];
$fecha=date("Y-m-d"); 
$hora=date ("H:i:s");
$fechahora = $fecha.' '.$hora;
$status = "";
$cadenaInsertar="INSERT INTO revision_cierre_historial (ID_REVISION_CIERRE, ID_USUARIOREVISA, FECHAHORA_REVISION)VALUES('$id_evidencia','$id_usuario','$fechahora')";
$insertar=mysqli_query($conexion,$cadenaInsertar);

$cadenaId="SELECT IFNULL(MAX(ID),0) FROM revision_cierre_historial";
$consultaId=mysqli_query($conexion,$cadenaId);
$rowId=mysqli_fetch_array($consultaId);
$id_historial=$rowId[0];
$fecha2=date("Ymd"); 
$hora2=date ("His");
if($id_historial>0){
  $directorio = "img/".$id_historial.".jpg";

  if(file_put_contents($directorio,$imagen)){
    $status = "Archivo subido"; 
  }else{ 
    $status = "Error al subir el archivo"; 
  }
}
echo $status;*/
?>