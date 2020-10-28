<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set('America/Monterrey');

$fecha=date("Y-m-d"); 
$hora=date ("H:i:s");

  $id_registro  = $_POST['id_registro'];
  $banco        = $_POST['banco'];
  $terminacion  = $_POST['terminacion'];
  $empresa      = $_POST['empresa'];
  $fecha_venta  = $_POST['fecha_venta'];
  $autoriza     = $_POST['autoriza'];
  $beneficiario = $_POST['beneficiario'];
  $nombre       = $_POST['nombre'];
  $telefono     = $_POST['telefono'];
  $direccion    = $_POST['direccion'];
  $monto        = $_POST['monto'];

  if (empty($id_registro)) {
    //Insertar nuevo registro
    //inserta registros textuales,ligado a bd de sql, no se liga por id a tablas de mysql
    $verificar=mysqli_query($conexion,"SELECT id FROM control_cheques WHERE id= '$id_registro'");
    $existe = mysqli_num_rows($verificar);

    if($existe == 0){
      $cadena_insertar = "INSERT INTO control_cheques (banco,terminacion,empresa,fecha_venta,autoriza,beneficiario,monto,nombre_cliente,direccion_cliente, telefono_cliente,sucursal, fecha, hora, activo, usuario)
      VALUES('$banco','$terminacion','$empresa','$fecha_venta','$autoriza','$beneficiario','$monto','$nombre','$direccion','$telefono','$id_sede','$fecha','$hora', '1', '$id_usuario')";
      $insertar_registro = mysqli_query($conexion,$cadena_insertar);
      echo "ok_nuevo";
    }
    else{
      echo "";
    }
  }elseif (!empty($id_registro)) {
    $cadena_actualizar = "UPDATE control_cheques SET banco = '$banco', terminacion='$terminacion',empresa= '$empresa',fecha_venta='$fecha_venta', autoriza='$autoriza', beneficiario='$beneficiario',monto='$monto',nombre_cliente='$nombre',direccion_cliente='$direccion', telefono_cliente='$telefono' WHERE id = '$id_registro'";
     $consulta_actualizar = mysqli_query($conexion, $cadena_actualizar);
    echo "ok_actualizado";
  }
?>