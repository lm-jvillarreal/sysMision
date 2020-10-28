
<?php
  include '../global_seguridad/verificar_sesion.php';
  $activo = $_POST['id_registro'];

  $consulta_verifica = mysqli_query($conexion, "SELECT activo FROM turnos WHERE id = '$consecutivo'");
  $row_verifica = mysqli_fetch_array($consulta_verifica);

  if ($row_verifica[0]=='0') {
    $activo = '1';
  }elseif($row_verifica[0]=='1'){
    $activo = '0';
  }

  $modifica_estado = mysqli_query($conexion, "UPDATE turnos SET activo = '$activo' WHERE id = '$consecutivo'");

  echo "ok";
?>