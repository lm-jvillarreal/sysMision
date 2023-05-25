<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set('America/Monterrey');

$fecha=date("Y-m-d"); 
$hora=date ("H:i:s");

  $id_registro = $_POST['id_registro1'];
  $categoria = $_POST['categoria'];
  
  if (empty($id_registro)) {
    //Insertar nuevo registro
    $verificar=mysqli_query($conexion,"SELECT id FROM categorias WHERE categoria= '$categoria'");
    $existe = mysqli_num_rows($verificar);

    if($existe == 0){
      $cadena_insertar = mysqli_query($conexion,"INSERT INTO categorias (categoria,fecha,hora,usuario, activo)
      VALUES('$categoria','$fecha','$hora','$id_usuario','1' )");
      echo "ok_nuevo";}
     else{
   
      echo "duplicado";
    }
  }elseif (!empty($id_registro)) {
    $cadena_actualizar = "UPDATE categorias SET categoria = '$categoria', fecha = '$fecha', hora='$hora', activo = '1', usuario='$id_usuario' WHERE id = '$id_registro'";
    $consulta_actualizar = mysqli_query($conexion, $cadena_actualizar);
    echo "ok_actualizado";
}
?>
