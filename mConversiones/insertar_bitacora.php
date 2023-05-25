<?php
  include '../global_seguridad/verificar_sesion.php';
  date_default_timezone_set('America/Monterrey');

  $fecha=date("Y-m-d"); 
  $hora=date ("H:i:s");
  $fechahora=date("Y-m-d H:i:s");

  $id_registro        = $_POST['id_registro'];
  $turno              = $_POST['turno'];
  $subreceta          = $_POST['subreceta'];
  $produccion         = $_POST['produccion'];
  $HarinaKilos        = $_POST['HarinaKilos'];
  $HarinaBultos       = $_POST['HarinaBultos'];

  $merma_masa         = $_POST['merma_masa'];
  $merma_tortilla     = $_POST['merma_tortilla'];
  $resultado          ="";

  if (empty($id_registro)) {
    if($subreceta == "SR MASA TORTILLA BLANCA"||$subreceta == "SR MASA TORTILLA TAQUERA"||$subreceta == "SR MASA TORTILLA ROJA"){
      $harinaUtilizada = $HarinaBultos;
    }else{
      $harinaUtilizada = $HarinaKilos;
    }
        $resultado = $masa/$tortillas;
        $RoundRes = number_format($resultado, 9);
        //echo $RoundRes;
        $cadenaInsertar= "INSERT INTO tor_bitacora_produccion (turno, sucursal, subreceta, produccion_teorica, harina_utilizada, merma_masa, merma_tortilla, usuario, fechahora, activo)
 			VALUES ('$turno','$id_sede','$subreceta', '$produccion', '$harinaUtilizada','$merma_masa','$merma_tortilla','$id_usuario','$fechahora', '1')";
      $Consulta_Insertar = mysqli_query($conexion, $cadenaInsertar);
        echo "ok_nuevo";
  }
  else{
    $resultado = $masa/$tortillas;
    $RoundRes = number_format($resultado, 9);
    $cadena_actualizar = "UPDATE tor_bitacora_produccion SET turno = '$turno',sucursal = '$id_sede', subreceta = '$subreceta', produccion_teorica = '$produccion', harina_utilizada = '$harinaUtilizada', merma_masa = '$merma_masa', merma_tortilla = '$merma_tortilla', fechahora='$fechahora', activo = '1', id_usuario='$id_usuario' WHERE id = '$id_registro'";
    $consulta_actualizar = mysqli_query($conexion, $cadena_actualizar);
    echo "ok_actualizado";
    //echo $cadena_actualizar;
  }
?>
