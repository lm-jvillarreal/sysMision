<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set('America/Monterrey');

$fecha=date("Y-m-d"); 
$hora=date ("H:i:s");

  $id_registro = $_POST['id_registro6'];
  $tipo = $_POST['tipo'];
  $categoria = $_POST['categoriaT'];
  
  if (empty($id_registro)) {
    //Insertar nuevo registro
    $verificar=mysqli_query($conexion,"SELECT id FROM tipos_incidencias WHERE id= '$id_registro'");
    $existe = mysqli_num_rows($verificar);

    if($existe == 0){
      $cadena_insertar ="INSERT INTO tipos_incidencias (tipo, categoria,fecha, hora, activo, usuario)
      VALUES('$tipo','$categoria','$fecha','$hora','1','$id_usuario')";
      mysqli_query($conexion,$cadena_insertar);
      echo "ok_nuevo";}
     else{
   
      echo "duplicado";
    }
  }elseif (!empty($id_registro)) {
    $cadena_actualizar = "UPDATE tipos_incidencias SET tipo = '$tipo', categoria = '$categoria',fecha = '$fecha', hora='$hora', activo = '1', usuario='$id_usuario' WHERE id = '$id_registro'";
    $consulta_actualizar = mysqli_query($conexion, $cadena_actualizar);
    echo "ok_actualizado";
}
?>
