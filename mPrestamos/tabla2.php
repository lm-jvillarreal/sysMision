<?php 
    include '../global_seguridad/verificar_sesion.php';
    // $filtro=(!empty($registros_propios) == '1')?" AND id_usuario = '$id_usuario'":"";
    // $filtro_sucursal = ($solo_sucursal=='1') ? " AND cajas.id_sucursal='$id_sede'":"";
    $folio = $_POST['folio'];
  
    $cadena  = "SELECT id,
                (SELECT descripcion FROM catalogo_piezas WHERE catalogo_piezas.codigo_interno = historial_prestamos.codigo_interno ),
                cantidad 
              FROM historial_prestamos 
              WHERE activo = '1' AND id_prestamo = '$folio'";
    $consulta = mysqli_query($conexion, $cadena);

    $cuerpo = "";
    $numero = 1;
  while ($row = mysqli_fetch_array($consulta)) 
  {
    $boton_eliminar="<center><button type='button' onclick='eliminar_detalle($row[0])' class='btn btn-danger btn-sm'><i class='fa fa-trash fa-lg' aria-hidden='true'></i></button></center>";

    $renglon = "
      {
      \"#\": \"$numero\",
      \"Parte\": \"$row[1]\",
      \"Cantidad\": \"$row[2]\",
      \"Eliminar\": \"$boton_eliminar\"
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