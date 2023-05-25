<?php 
  include '../global_seguridad/verificar_sesion.php';
  $filtro=(!empty($registros_propios) == '1')?" AND id_usuario = '$id_usuario'":"";
  $filtro_sucursal = ($solo_sucursal=='1') ? " AND cajas.id_sucursal='$id_sede'":"";
  
  $datos = array();
  $sucursal = $_POST['sucursal'];
  
  $cadena  = "SELECT
              id
            FROM
              cajas 
            WHERE
              activo = '1' 
            AND id_sucursal = '$id_sede'";
  $numero = 1;
  $consulta = mysqli_query($conexion, $cadena);

  
  while ($row = mysqli_fetch_array($consulta)) 
  {
    $cadena_nombre = "SELECT nombre FROM cajas WHERE activo = '1' AND id= '$row[0]'";
    $consulta_nombre = mysqli_query($conexion, $cadena_nombre);
    $row_nombre = mysqli_fetch_array($consulta_nombre);
     array_push($datos,array(
        $row[0],
        $row_nombre[0]//,id_caja
     ));  
}

  echo utf8_encode(json_encode($datos));
?>