<?php 
    include '../global_seguridad/verificar_sesion.php';
    $filtro=(!empty($registros_propios) == '1')?" AND hp.id_usuario = '$id_usuario'":"";
    // $filtro_sucursal = ($solo_sucursal=='1') ? " AND cajas.id_sucursal='$id_sede'":"";
  
    $cadena  = "SELECT
                    hp.id,
                    p.persona,
                    (SELECT nombre FROM sucursales WHERE sucursales.id = p.id_sucursal ),
                    (SELECT descripcion FROM catalogo_piezas WHERE catalogo_piezas.codigo_interno = hp.codigo_interno ),
                    hp.cantidad,
                    DATE_FORMAT(p.fecha_entrega,'%d-%m-%Y'),
                    hp.cantidad_entregada
                FROM historial_prestamos hp
                INNER JOIN prestamos p ON p.id = hp.id_prestamo
                WHERE hp.activo = '2'".$filtro;
    $consulta = mysqli_query($conexion, $cadena);

    $cuerpo = "";
    $numero = 1;
  while ($row = mysqli_fetch_array($consulta)) 
  {
    $renglon = "
      {
      \"#\": \"$numero\",
      \"Persona\": \"$row[1]\",
      \"Sucursal\": \"$row[2]\",
      \"Pieza\": \"$row[3]\",
      \"Cantidad\": \"$row[4]\",
      \"CantidadE\": \"$row[6]\",
      \"Fecha\": \"$row[5]\"
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