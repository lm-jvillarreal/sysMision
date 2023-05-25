<?php
include '../global_seguridad/verificar_sesion.php';
$folio_inicial = $_POST['folio_inicial'];
$folio_final = $_POST['folio_final'];

$cadenaValidar="SELECT * FROM registro_boletos2 WHERE folio_boleto>='$folio_inicial' AND folio_boleto<='$folio_final' AND usuario='$id_usuario'";
$consultaValidar = mysqli_query($conexion,$cadenaValidar);
$rowValidar=mysqli_fetch_array($consultaValidar);
$conteoValidar=count($rowValidar[0]);
if($conteoValidar>0){
  echo "ya_existe";
}else{
  for($i=$folio_inicial; $i<=$folio_final; $i=$i+1){
    $CadenaInsertar="INSERT INTO registro_boletos2 (folio_boleto, sucursal, estatus, fecha, hora, activo, usuario)VALUES('$i','$id_sede','1','$fecha','$hora','1','$id_usuario')";
    $insertarFolios=mysqli_query($conexion,$CadenaInsertar);
  }
  echo "ok";
}
?>