<?php 
    include '../global_seguridad/verificar_sesion.php';
    // $filtro=(!empty($registros_propios) == '1')?" AND id_usuario = '$id_usuario'":"";
    // $filtro_sucursal = ($solo_sucursal=='1') ? " AND cajas.id_sucursal='$id_sede'":"";
    $id = $_POST['id'];
  
    $cadena  = "SELECT
                  id,
                  (SELECT descripcion FROM catalogo_piezas WHERE catalogo_piezas.codigo_interno = detalle_historial_requisicion.codigo), 
                  cantidad,
                  activo
                FROM detalle_historial_requisicion 
                WHERE (activo = '1' OR activo = '2') AND id_historial = '$id'";
    $consulta = mysqli_query($conexion, $cadena);

    $cuerpo = "";
    $numero = 1;
  while ($row = mysqli_fetch_array($consulta)) 
  {
    $boton_liberar=($row[3] == 1)?"<center><button type='button' onclick='liberar_pieza($row[0],$id)' class='btn btn-success btn-sm'><i class='fa fa-check-circle fa-lg' aria-hidden='true'></i></button></center>":"<center>Pieza Liberada</center>";

    $renglon = "
      {
      \"#\": \"$numero\",
      \"Parte\": \"$row[1]\",
      \"Cantidad\": \"$row[2]\",
      \"Liberar\": \"$boton_liberar\"
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