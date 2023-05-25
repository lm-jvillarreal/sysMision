<?php
  include '../global_seguridad/verificar_sesion.php';
  date_default_timezone_set('America/Monterrey');

  $fecha=date("Y-m-d"); 
  $hora=date ("H:i:s");
  $fechahora=date("Y-m-d H:i:s");

  $id_registro        = $_POST['id_registro'];
  $conversion         = $_POST['conversion'];
  $medida             = $_POST['medida'];
  $masa               = $_POST['masa'];
  $tortillas          = $_POST['tortillas'];
  $resultado          ="";

  if (empty($id_registro)) {
        $resultado = $masa/$tortillas;
        $RoundRes = number_format($resultado, 9);
        //echo $RoundRes;
        $cadenaInsertar= "INSERT INTO conversiones_tor (conversion, medida, masa, tortillas, resultado, id_usuario, fechahora, activo)
 			VALUES ('$conversion','$medida', '$masa', '$tortillas','$RoundRes','$id_usuario','$fechahora', '1')";
      $Consulta_Insertar = mysqli_query($conexion, $cadenaInsertar);
        echo "ok_nuevo";
  }
  else{
    $resultado = $masa/$tortillas;
    $RoundRes = number_format($resultado, 9);
    $cadena_actualizar = "UPDATE conversiones_tor SET conversion = '$conversion', medida = '$medida', masa = '$masa', tortillas = '$tortillas', resultado = '$RoundRes', fechahora='$fechahora', activo = '1', id_usuario='$id_usuario' WHERE id = '$id_registro'";
    $consulta_actualizar = mysqli_query($conexion, $cadena_actualizar);
    echo "ok_actualizado";
    //echo $cadena_actualizar;
  }
?>
