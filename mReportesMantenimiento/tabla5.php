<?php 
    include '../global_seguridad/verificar_sesion.php';
    // $filtro=(!empty($registros_propios) == '1')?" AND id_usuario = '$id_usuario'":"";
    // $filtro_sucursal = ($solo_sucursal=='1') ? " AND cajas.id_sucursal='$id_sede'":"";

    $fecha1 = $_POST['fecha1'];
    $fecha2 = $_POST['fecha2'];
    $sucursal = $_POST['sucursal'];
    $sucursal2 = $_POST['sucursal2'];
    $articulo = $_POST['articulo'];

    if(!empty($_POST['fecha1']) && !empty($_POST['fecha2'])){
        $filtro_fecha  = " AND fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)";
    }else{
        $filtro_fecha  = "";
    }
    $filtro_sucursal = (!empty($_POST['sucursal']))?" AND id_sucursal_origen = '$sucursal'":"";
    $filtro_sucursal2 = (!empty($_POST['sucursal']))?" AND id_sucursal_destino = '$sucursal'":"";
    $filtro_articulo = (!empty($_POST['articulo']))?" AND codigo_interno = '$articulo'":"";
  
    $cadena  = "SELECT
                    (SELECT nombre FROM sucursales WHERE sucursales.id = traspasos.id_sucursal_origen),
                    codigo_interno,
                    ( SELECT descripcion FROM catalogo_piezas WHERE catalogo_piezas.codigo_interno = traspasos.codigo_interno ),
                    cantidad,
                    (SELECT nombre FROM sucursales WHERE sucursales.id = traspasos.id_sucursal_destino)
                FROM traspasos 
                WHERE activo = '1'".$filtro_fecha.$filtro_sucursal.$filtro_articulo;
                // echo $cadena;
    $consulta = mysqli_query($conexion, $cadena);

    $cuerpo = "";
    $numero = 1;
  while ($row = mysqli_fetch_array($consulta)) 
  {
    $descrip = mysqli_real_escape_string($conexion, $row[2]);
    $renglon = "
      {
      \"#\": \"$numero\",
      \"SucursalO\": \"$row[0]\",
      \"Codigo\": \"$row[1]\",
      \"Descripcion\": \"$descrip\",
      \"Cantidad\": \"$row[3]\",
      \"SucursalD\": \"$row[4]\"
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