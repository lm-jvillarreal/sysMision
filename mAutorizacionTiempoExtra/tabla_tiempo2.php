<?php
  // esto permite tener acceso desde otro servidor
    header('Access-Control-Allow-Origin: *');
  // esto permite tener acceso desde otro servidor
  include '../global_settings/conexion.php';
  include '../global_settings/consulta_sqlsrvr.php';
  date_default_timezone_set('America/Monterrey');
  $fecha      = date('Y-m-d');
  function _data_last_month_day() { 
    $month = date('m');
    $year = date('Y');
    $day = date("d", mktime(0,0,0, $month+1, 0, $year));
    return date('Y-m-d', mktime(0,0,0, $month, $day, $year));
  };
  /* Actual month first day */  
  function _data_first_month_day() {
    $month = date('m');
    $year = date('Y');
    return date('Y-m-d', mktime(0,0,0, $month, 1, $year));
  }
  $fecha1 = _data_first_month_day();
  $fecha2 = _data_last_month_day();
  $filtro_registros_propios = ($registros_propios=="0") ? "" : " AND ti.usuario = '$id_usuario'";
  $tiempo = "";
  $nombre_empleado="";
  $departamento="";
  $sucursal="";

  $cadena  = "SELECT
    id,
    nombre,
    departamento,
    sucursal,
    TIME_FORMAT(tiempo,'%H:%i:%s'),
    comentario,
    DATE_FORMAT(tiempo_extra.fecha_inicio,'%d/%m/%Y') ,
    (SELECT CONCAT(nombre,' ',ap_paterno,' ',ap_materno) FROM usuarios INNER JOIN personas ON personas.id = usuarios.id_persona WHERE usuarios.id = tiempo_extra.usuario)
    usuario,
    folio,
    motivo
    FROM
    tiempo_extra where folio='0'";
  // BETWEEN '$fecha1' AND '$fecha2'
  // ='$fecha'
  // fecha='$fecha'
  $consulta = mysqli_query($conexion, $cadena);
  $cuerpo         = "";
  $numero = 1;

  while ($row_incidencias = mysqli_fetch_array($consulta)) 
  {
    $tiempo = $row_incidencias[4];
    // $tiempo = substr($tiempo,0,5);
    $autorizar = "<div class='input-group' style='width:100%''><input type='text' id='$row_incidencias[0]' class='form-control'><span class='input-group-btn'><button id='btn_autorizar$numero' onclick='autorizar($row_incidencias[0],$row_incidencias[8],$numero)' class='btn btn-danger' type='button'><i class='fa fa-floppy-o fa-lg' aria-hidden='true'></i></button></span></div> <input type='hidden'value='$tiempo' id='tiempo$numero'>";
    $rechazar = "<a href='#' data-id = '$row_incidencias[0]' data-toggle = 'modal' data-target = '#modal-rechazar' class='btn btn-danger' target='blank'>Rechazar</a>";
    $editar = "<center><a href='#' onclick='editar($row_incidencias[0])'>$row_incidencias[0]</a></center>";
    $chk_activo = "<center><input type='checkbox' name='activo' id='activo' $activo onchange='estatus($row_incidencias[0])'></center>";
    $departamento=ucwords(strtolower($row_incidencias[2]));
    $sucursal=ucwords(strtolower($row_incidencias[3]));
    $chk_autorizacion = "<center><input type='checkbox' name='autorizacion' id='autorizacion' $autorizacion onchange='autorizacion($row_incidencias[0])'></center>";
    $cadena_persona = "SELECT nombre, ap_paterno, ap_materno FROM empleados WHERE codigo = '$row_incidencias[1]'";
    $consulta_persona = sqlsrv_query($conn, $cadena_persona);
    $row_persona = sqlsrv_fetch_array( $consulta_persona, SQLSRV_FETCH_ASSOC);
    $nombre_empleado = $row_persona['nombre'].' '.$row_persona['ap_paterno'].' '.$row_persona['ap_materno'];
    $nombre_empleado=ucwords(strtolower($nombre_empleado));
    $empleado = $row_incidencias[1].' - '.$nombre_empleado; 
    
    $renglon = "
      {
      \"id\":           \"$numero\",
      \"nombre\":       \"$empleado\",
      \"departamento\": \"$departamento\",
      \"sucursal\":     \"$sucursal\",
      \"motivo\":       \"$row_incidencias[9]\",
      \"autoriza\":     \"$row_incidencias[7]\",
      \"tiempo\":       \"$tiempo\",
      \"comentario\":   \"$row_incidencias[5]\",
      \"fecha\":        \"$row_incidencias[6]\",
      \"activo\":       \"$autorizar\"
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
