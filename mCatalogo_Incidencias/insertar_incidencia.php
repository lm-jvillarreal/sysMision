<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set('America/Monterrey');

$fecha=date("Y-m-d"); 
$hora=date ("H:i:s");

  $id_registro = $_POST['id_registro'];
  $nombre = $_POST['nombre'];
  $gravedad=$_POST['gravedad'];
  $categoria=$_POST['categoria'];
  $formato=$_POST['formato'];
  $accion=$_POST['accion'];
  
  if (empty($id_registro)) {
    //Insertar nuevo registro
    $verificar=mysqli_query($conexion,"SELECT id_incidencia FROM catalogo_incidencias WHERE nombre= '$nombre'");
    $existe = mysqli_num_rows($verificar);

    if($existe == 0){
      $cadena = mysqli_query($conexion,"INSERT INTO catalogo_incidencias (nombre,gravedad,categoria,accion,formato,fecha,hora,activo, id_usuario)
      VALUES('$nombre','$gravedad','$categoria','$accion','$formato','$fecha','$hora','1', '$id_usuario')");
      echo "ok_nuevo";
    }
    else{
      echo "duplicado";
    }
  }elseif (!empty($id_registro)) {
    $cadena_actualizar = "UPDATE catalogo_incidencias SET nombre = '$nombre',categoria='$categoria', gravedad='$gravedad', accion= '$accion', fecha = '$fecha', hora='$hora', activo = '1', id_usuario='$id_usuario' WHERE id_incidencia = '$id_registro'";
    $consulta_actualizar = mysqli_query($conexion, $cadena_actualizar);
    echo "ok_actualizado";
  }
?>
