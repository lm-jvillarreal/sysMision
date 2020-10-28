  <?php
  include '../global_seguridad/verificar_sesion.php';
  $cadena = mysqli_query($conexion,"SELECT MAX(id) FROM equipo_ups WHERE activo = '1'");
  $row1 = mysqli_fetch_array($cadena);
  $cadena = mysqli_query($conexion,"SELECT id_sucursal, marca, modelo, tipo, capacidad, entrada_salida, tomacorrientes, tiempo_respaldo, garantia, series FROM equipo_ups WHERE id = '$row1[0]'");
  $row = mysqli_fetch_array($cadena);
  $array = array($row[0],$row[1],$row[2],$row[3],$row[4],$row[5],$row[6],$row[7],$row[8],$row[9]);
  echo json_encode($array);
?>