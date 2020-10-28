<?php 
    include '../global_seguridad/verificar_sesion.php';
    $filtro=(!empty($registros_propios) == '1')?" AND id_usuario = '$id_usuario'":"";
    // $filtro_sucursal = ($solo_sucursal=='1') ? " AND cajas.id_sucursal='$id_sede'":"";
  
    $cadena  = "SELECT
                  id,
                  (SELECT nombre FROM sucursales WHERE sucursales.id = historial_requisicion.id_sucursal),
                  justificacion,
                  area,
                  orden_trabajo
                FROM historial_requisicion 
                WHERE activo = '1'".$filtro;
    $consulta = mysqli_query($conexion, $cadena);

    $cuerpo = "";
    $numero = 1;
  while ($row = mysqli_fetch_array($consulta)) 
  {
    $boton_ver="<center><button type='button' onclick='liberar($row[0])' class='btn btn-warning btn-sm'><i class='fa fa-arrow-circle-down fa-lg' aria-hidden='true'></i></button></center>";

    $renglon = "
      {
      \"#\": \"$numero\",
      \"Sucursal\": \"$row[1]\",
      \"Area\": \"$row[3]\",
      \"Justificacion\": \"$row[2]\",
      \"Orden\": \"$row[4]\",
      \"Ver\": \"$boton_ver\"
      },";
    $cuerpo = $cuerpo.$renglon;
    $numero ++;
  }
  $cuerpo2 = trim($cuerpo,','); ///Quitarle la coma
  $tabla = "
    ["
    .$cuerpo2.
    "]
    ";
  echo $tabla;
?>