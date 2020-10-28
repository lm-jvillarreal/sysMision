<?php 
    include '../global_seguridad/verificar_sesion.php';
    // $filtro=(!empty($registros_propios) == '1')?" AND id_usuario = '$id_usuario'":"";
    // $filtro_sucursal = ($solo_sucursal=='1') ? " AND cajas.id_sucursal='$id_sede'":"";
  
    $folio = $_POST['folio'];
    $cadena  = "SELECT id_historial,
                  (SELECT descripcion FROM catalogo_piezas WHERE catalogo_piezas.codigo_interno = historial_entradas.codigo_interno ),
                  cantidad,
                  ult_costo,
                  (SELECT nombre FROM sucursales WHERE sucursales.id = historial_entradas.id_almacen) 
                FROM historial_entradas
                WHERE folio = '$folio' AND activo = '1'";
    $consulta = mysqli_query($conexion, $cadena);

    $cuerpo = "";
    $numero = 1;
  while ($row = mysqli_fetch_array($consulta)) 
  {
    $renglon = "
      {
      \"#\": \"$numero\",
      \"Parte\": \"$row[1]\",
      \"Cantidad\": \"$row[2]\",
      \"UltCosto\": \"$ $row[3]\",
      \"Sucursal\": \"$row[4]\"
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