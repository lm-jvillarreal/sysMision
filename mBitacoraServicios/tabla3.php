<?php 
  include '../global_seguridad/verificar_sesion.php';
  
  $filtro=(!empty($registros_propios) == '1')?" AND id_usuario = '$id_usuario'":"";
  $cadena  = "SELECT id,descripcion,monto_total,(SELECT nombre FROM sucursales WHERE sucursales.id = pagos_servicios.id_sucursal) FROM pagos_servicios WHERE activo = '1'".$filtro;
  $consulta = mysqli_query($conexion, $cadena);

  $cuerpo = "";
  $numero = 1;
  while ($row = mysqli_fetch_array($consulta)) 
  {
    $cadena2 = mysqli_query($conexion,"SELECT SUM(bitacora_servicios.gasto) FROM detalle_pago_servicios INNER JOIN bitacora_servicios ON bitacora_servicios.id = detalle_pago_servicios.id_bitacora_servicio WHERE detalle_pago_servicios.activo = '1' AND id_pago = '$row[0]'");
    $row2 = mysqli_fetch_array($cadena2);

    $boton_editar="<button href='#' onclick='editar_pago($row[0])' class='btn btn-warning btn-sm'><i class='fa fa-edit fa-lg' aria-hidden='true'></i></button>";
    $boton_eliminar="<button onclick='eliminar_pago($row[0])' class='btn btn-danger btn-sm'><i class='fa fa-trash fa-lg' aria-hidden='true'></i></button>";
    $boton_pdf = "<a href='pdf.php?id_pago=$row[0]' target='_blank' ><button class='btn btn-danger btn-sm'><i class='fa fa-file-pdf-o fa-lg' aria-hidden='true'></i></button></a>";
    $renglon = "
      {
      \"#\": \"$numero\",
      \"Descripcion\": \"$row[1]\",
      \"MontoTotal\": \"$ $row2[0]\",
      \"Sucursal\": \"$row[3]\",
      \"Acciones\": \"$boton_editar $boton_eliminar $boton_pdf\"
      },";
    $cuerpo = $cuerpo.$renglon;
    $numero ++;
    $ruta = "";
    $ruta2 = "";
    $imagenes = "";
  }
  $cuerpo2 = trim($cuerpo,','); ///Quitarle la coma
  $tabla = "
    ["
    .$cuerpo2.
    "]
    ";
  echo $tabla;
?>
