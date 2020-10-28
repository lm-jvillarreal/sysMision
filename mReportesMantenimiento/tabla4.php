<?php 
    include '../global_seguridad/verificar_sesion.php';
    // $filtro=(!empty($registros_propios) == '1')?" AND id_usuario = '$id_usuario'":"";
    // $filtro_sucursal = ($solo_sucursal=='1') ? " AND cajas.id_sucursal='$id_sede'":"";

    $fecha1 = $_POST['fecha1'];
    $fecha2 = $_POST['fecha2'];
    $sucursal = $_POST['sucursal'];
    $articulo = $_POST['articulo'];

    if(!empty($_POST['fecha1']) && !empty($_POST['fecha2'])){
        $filtro_fecha  = " AND prestamos.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)";
    }else{
        $filtro_fecha  = "";
    }
    $filtro_sucursal = (!empty($_POST['sucursal']))?" AND prestamos.id_sucursal = '$sucursal'":"";
    $filtro_articulo = (!empty($_POST['articulo']))?" AND historial_prestamos.codigo_interno = '$articulo'":"";
  
    $cadena  = "SELECT
                    prestamos.persona,
                    (SELECT nombre FROM sucursales WHERE sucursales.id = prestamos.id_sucursal),
                    historial_prestamos.codigo_interno,
                    (SELECT descripcion FROM catalogo_piezas WHERE catalogo_piezas.codigo_interno = historial_prestamos.codigo_interno),
                    historial_prestamos.cantidad,
                    prestamos.fecha_entrega
                FROM historial_prestamos 
                INNER JOIN prestamos ON prestamos.id = historial_prestamos.id_prestamo
                WHERE historial_prestamos.activo = '1'".$filtro_fecha.$filtro_sucursal.$filtro_articulo;
                // echo $cadena;
    $consulta = mysqli_query($conexion, $cadena);

    $cuerpo = "";
    $numero = 1;
  while ($row = mysqli_fetch_array($consulta)) 
  {
    $descrip = mysqli_real_escape_string($conexion, $row[3]);
    $renglon = "
      {
      \"#\": \"$numero\",
      \"Persona\": \"$row[0]\",
      \"Almacen\": \"$row[1]\",
      \"Codigo\": \"$row[2]\",
      \"Descripcion\": \"$descrip\",
      \"Cantidad\": \"$row[4]\",
      \"FechaEntrega\": \"$row[5]\"
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