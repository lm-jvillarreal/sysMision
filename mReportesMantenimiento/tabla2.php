<?php 
    include '../global_seguridad/verificar_sesion.php';
    // $filtro=(!empty($registros_propios) == '1')?" AND id_usuario = '$id_usuario'":"";
    // $filtro_sucursal = ($solo_sucursal=='1') ? " AND cajas.id_sucursal='$id_sede'":"";

    $fecha1 = $_POST['fecha1'];
    $fecha2 = $_POST['fecha2'];
    $proveedor = $_POST['proveedor'];
    $sucursal = $_POST['sucursal'];
    $familia = $_POST['familia'];
    $articulo = $_POST['articulo'];

    if(!empty($_POST['fecha1']) && !empty($_POST['fecha2'])){
        $filtro_fecha  = " AND historial_entradas.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)";
    }else{
        $filtro_fecha  = "";
    }
    $filtro_proveedor = (!empty($_POST['proveedor']))?" AND id_proveedor = '$proveedor'":"";
    $filtro_sucursal = (!empty($_POST['sucursal']))?" AND id_almacen = '$sucursal'":"";
    $filtro_familia = (!empty($_POST['familia']))?" AND familia = '$familia'":"";
    $filtro_articulo = (!empty($_POST['articulo']))?" AND codigo_interno = '$articulo'":"";
  
    $cadena  = "SELECT
                    historial_entradas.fecha, 
                    (SELECT nombre FROM sucursales WHERE sucursales.id = historial_entradas.id_almacen),
                    codigo_interno,
                    (SELECT descripcion FROM catalogo_piezas WHERE catalogo_piezas.codigo_interno = historial_entradas.codigo_interno),
                    cantidad, 
                    ult_costo,
                    (cantidad * ult_costo)
                FROM historial_entradas
                INNER JOIN entradas ON entradas.id_entrada = historial_entradas.folio
                WHERE historial_entradas.activo = '1'".$filtro_fecha.$filtro_proveedor.$filtro_sucursal.$filtro_familia.$filtro_articulo;
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
      \"Fecha\": \"$row[0]\",
      \"Almacen\": \"$row[1]\",
      \"Codigo\": \"$row[2]\",
      \"Descripcion\": \"$descrip\",
      \"Cantidad\": \"$row[4]\",
      \"UltCosto\": \"$row[5]\",
      \"CostoTotal\": \"$row[6]\"
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