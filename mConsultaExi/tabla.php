<?php 
    include '../global_seguridad/verificar_sesion.php';
    $filtro=(!empty($registros_propios) == '1')?" AND id_usuario = '$id_usuario'":"";
    // $filtro_sucursal = ($solo_sucursal=='1') ? " AND cajas.id_sucursal='$id_sede'":"";
  
    $cadena  = "SELECT
    h.codigo_interno,
    f.nombre,
    c.descripcion,
    ( SELECT nombre FROM sucursales WHERE sucursales.id = h.id_almacen ) ,
    c.rack,
    c.columna,
    c.fila,
    h.cantidad,
    c.foto
    FROM historial_existencias AS h
    LEFT JOIN catalogo_piezas AS c ON c.codigo_interno = h.codigo_interno
    LEFT JOIN familias_mantenimiento AS f ON f.clave_familia = c.clave_familia
    WHERE f.nombre != ''".$filtro;
    $consulta = mysqli_query($conexion, $cadena);

    $cuerpo = "";
    $numero = 1;
  while ($row = mysqli_fetch_array($consulta)) 
  {
    $descripcion = mysqli_real_escape_string($conexion, $row[2]);
    // echo $descripcion;
    $renglon = "
      {
      \"#\": \"$numero\",
      \"Codigo\": \"$row[0]\",
      \"Familia\": \"$row[1]\",
      \"Descripcion\": \"$descripcion\",
      \"Almacen\": \"$row[3]\",
      \"Rack\": \"$row[4]\",
      \"Columna\": \"$row[5]\",
      \"Fila\": \"$row[6]\",
      \"Cantidad\": \"$row[7]\",
      \"Foto\": \"$row[8]\"
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