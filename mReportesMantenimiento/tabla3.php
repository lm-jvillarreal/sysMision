<?php 
    include '../global_seguridad/verificar_sesion.php';
    // $filtro=(!empty($registros_propios) == '1')?" AND id_usuario = '$id_usuario'":"";
    // $filtro_sucursal = ($solo_sucursal=='1') ? " AND cajas.id_sucursal='$id_sede'":"";

    $fecha1 = $_POST['fecha1'];
    $fecha2 = $_POST['fecha2'];
    $sucursal2 = $_POST['sucursal2'];
    $sucursal = $_POST['sucursal'];
    $familia = $_POST['familia'];
    $articulo = $_POST['articulo'];

    if(!empty($_POST['fecha1']) && !empty($_POST['fecha2'])){
        $filtro_fecha  = " AND historial_salidas.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)";
    }else{
        $filtro_fecha  = "";
    }
    $filtro_sucursal2 = (!empty($_POST['sucursal2']))?" AND salidas.id_sucursal = '$sucursal2'":"";
    $filtro_sucursal = (!empty($_POST['sucursal']))?" AND historial_salidas.id_almacen = '$sucursal'":"";
    $filtro_familia = (!empty($_POST['familia']))?" AND catalogo_piezas.clave_familia = '$familia'":"";
    $filtro_articulo = (!empty($_POST['articulo']))?" AND historial_salidas.codigo_interno = '$articulo'":"";
  
    $cadena  = "SELECT
                    historial_salidas.fecha,
                    (SELECT nombre FROM sucursales WHERE sucursales.id = salidas.id_sucursal),
                    catalogo_piezas.codigo_interno,
                    (SELECT descripcion FROM catalogo_piezas WHERE catalogo_piezas.codigo_interno = historial_salidas.codigo_interno),
                    historial_salidas.cantidad,
                    catalogo_piezas.ult_costo_pza,
                    (historial_salidas.cantidad * catalogo_piezas.ult_costo_pza)
                FROM salidas
                INNER JOIN historial_salidas ON salidas.id_sal = historial_salidas.folio
                INNER JOIN catalogo_piezas ON historial_salidas.codigo_interno = catalogo_piezas.codigo_interno
                WHERE salidas.activo = '1'".$filtro_fecha.$filtro_sucursal2.$filtro_sucursal.$filtro_familia.$filtro_articulo;
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