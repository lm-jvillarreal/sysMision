<?php
  include '../global_seguridad/verificar_sesion.php';
  date_default_timezone_set('America/Monterrey');

  $fecha=date("Y-m-d"); 
  $hora=date ("H:i:s");
  $fechahora=date("Y-m-d H:i:s");

  $subreceta          = $_POST['articulo'];
  $id_registro         = $_POST['id'];
  $Merma_Masa = $_POST['MermaMasa'];
  $Merma_Tortilla = $_POST['MermaTortilla'];
  $Prod_Teorica = $_POST['ProdTeorica'];
  $Harina_Utilizada = $_POST['HarinaUtilizada'];

  $resultado            ="";

  $cadenaExiste="SELECT COUNT(id) FROM tor_bitacora_produccion WHERE id= '$id_registro'";
  $consultaExiste = mysqli_query($conexion, $cadenaExiste);
  $rowExiste = mysqli_fetch_array($consultaExiste);


  if ($rowExiste[0]>0) {
    $cadena_actualizar = "UPDATE tor_bitacora_produccion SET harina_utilizada = '$Harina_Utilizada', subreceta = '$subreceta', merma_masa = '$Merma_Masa', merma_tortilla = '$Merma_Tortilla', produccion_teorica = '$Prod_Teorica', fechahora='$fechahora', activo = '1', usuario='$id_usuario' WHERE id = '$id_registro'";
    $consulta_actualizar = mysqli_query($conexion, $cadena_actualizar);
    echo $cadena_actualizar;
  }
  else{
    // $cadenaInsertar= "INSERT INTO tor_bitacora_produccion (conversion, medida, masa, tortillas, resultado, id_usuario, fechahora, activo)
    // VALUES ('$conversion','$medida', '$masa', '$tortillas','$RoundRes','$id_usuario','$fechahora', '1')";
   //$Consulta_Insertar = mysqli_query($conexion, $cadenaInsertar);
      echo $rowExiste[0];
  }
?>
