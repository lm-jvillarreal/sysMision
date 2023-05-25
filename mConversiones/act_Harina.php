<?php
  include '../global_seguridad/verificar_sesion.php';
  date_default_timezone_set('America/Monterrey');

  $fecha=date("Y-m-d"); 
  $hora=date ("H:i:s");
  $fechahora=date("Y-m-d H:i:s");

  $id                 = $_POST['id'];
  $harina_Utilizada   = $_POST['harina_Utilizada'];
  $id_registro        = $_POST['id_registro'];
  $resultado          ="";

  if (empty($id_registro)) {
        // $resultado = $masa/$tortillas;
        // $RoundRes = number_format($resultado, 9);
        // //echo $RoundRes;
        $cadenaInsertar= "INSERT INTO tor_bitacora_produccion (turno, subreceta, produccion_teorica, harina_utilizada, merma_masa, merma_tortilla, usuario, fechahora, activo)
 			VALUES ('$turno','$subreceta', '$produccion', '$masa','$merma_masa','$merma_tortilla','$id_usuario','$fechahora', '1')";
      //$Consulta_Insertar = mysqli_query($conexion, $cadenaInsertar);
        echo "ok_nuevo";
  }
  else{
    $resultado = $masa/$tortillas;
    $RoundRes = number_format($resultado, 9);
    $cadena_actualizar = "UPDATE tor_bitacora_produccion SET turno = '$turno', subreceta = '$subreceta', produccion_teorica = '$produccion', harina_utilizada = '$masa', merma_masa = '$merma_masa', merma_tortilla = '$merma_tortilla', fechahora='$fechahora', activo = '1', id_usuario='$id_usuario' WHERE id = '$id_registro'";
    //$consulta_actualizar = mysqli_query($conexion, $cadena_actualizar);
    echo "ok_actualizado";
    //echo $cadena_actualizar;
  }
?>
