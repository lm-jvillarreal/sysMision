<?php 
    include '../global_seguridad/verificar_sesion.php';
    // $filtro=(!empty($registros_propios) == '1')?" AND id_usuario = '$id_usuario'":"";
    // $filtro_sucursal = ($solo_sucursal=='1') ? " AND cajas.id_sucursal='$id_sede'":"";

    $fecha1 = $_POST['fecha1'];
    $fecha2 = $_POST['fecha2'];
    $sucursal = $_POST['sucursal'];
    $area = (isset($_POST['area']))?$_POST['area']:"";
    $tipo_actividad = $_POST['tipo_actividad'];
    $usuario = $_POST['ide_usuario'];

    if(!empty($_POST['fecha1']) && !empty($_POST['fecha2'])){
        $filtro_fecha  = " AND fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)";
    }else{
        $filtro_fecha  = "";
    }
    $filtro_sucursal = (!empty($_POST['sucursal']))?" AND id_sucursal = '$sucursal'":"";
    $filtro_area = (!empty($_POST['area']))?" AND id_area = '$area'":"";
    $filtro_tipo_actividad = (!empty($_POST['tipo_actividad']))?" AND id_t_actividad = '$tipo_actividad'":"";
    $filtro_id_usuario = (!empty($usuario))?" AND id_usuario = '$usuario'":"";
  
    $cadena  = "SELECT
                    actividad,
                    (SELECT nombre FROM areas_mantenimiento WHERE areas_mantenimiento.id = actividades_mantenimiento.id_area),
                    (SELECT nombre FROM tipo_actividad_mantenimiento WHERE tipo_actividad_mantenimiento.id = actividades_mantenimiento.id_t_actividad),
                    (SELECT nombre FROM sucursales WHERE sucursales.id = actividades_mantenimiento.id_sucursal),
                    tiempo,
                    fecha,
                    (SELECT CONCAT(p.nombre,' ',p.ap_paterno,' ',p.ap_materno) FROM personas as p inner join usuarios as u ON p.id=u.id_persona where u.id = actividades_mantenimiento.id_usuario) as realiza
                FROM actividades_mantenimiento
                WHERE activo = '1'".$filtro_fecha.$filtro_sucursal.$filtro_area.$filtro_tipo_actividad.$filtro_id_usuario;
                // echo $cadena;
    $consulta = mysqli_query($conexion, $cadena);

    $cuerpo = "";
    $numero = 1;
  while ($row = mysqli_fetch_array($consulta)) 
  {
    $act = mysqli_real_escape_string($conexion, $row[0]);
    $renglon = "
      {
      \"#\": \"$numero\",
      \"realiza\": \"$row[6]\",
      \"Actividad\": \"$act\",
      \"Area\": \"$row[1]\",
      \"TActividad\": \"$row[2]\",
      \"Sucursal\": \"$row[3]\",
      \"Tiempo\": \"$row[4]\",
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