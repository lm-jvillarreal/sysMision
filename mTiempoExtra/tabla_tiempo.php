<?php
// esto permite tener acceso desde otro servidor
    //header('Access-Control-Allow-Origin: *');
  // esto permite tener acceso desde otro servidor
// include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion.php';
include '../global_settings/consulta_sqlsrvr.php';
include '../global_seguridad/verificar_sesion.php';

$filtro_registros_propios = ($registros_propios=="0") ? "" : " AND ti.usuario='$id_usuario'";
$fecha1=date("2021/05/27"); 
$tiempo = "";
$nombre_empleado="";
$departamento="";
$sucursal="";

$idUsr = $_POST['idUsr'];

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
            motivo
            FROM
            tiempo_extra WHERE usuario = '$idUsr'and activo = '1'";
            // usuario = '$idUsr'
// where activo='1'
  $consulta = mysqli_query($conexion, $cadena);
  $cuerpo         = "";

  while ($row_incidencias = mysqli_fetch_array($consulta)) 
  {
    // $autorizar = "<center><span class='label label-warning'>Pendiente</span></center>";
    $editar = "<center><a href='#' onclick='editar($row_incidencias[0])'>$row_incidencias[0]</a></center>";
    $chk_activo = "<center><input type='checkbox' name='activo' id='activo' $activo onchange='estatus($row_incidencias[0])'></center>";
    $departamento=ucwords(strtolower($row_incidencias[2]));
    $sucursal=ucwords(strtolower($row_incidencias[3]));
    $chk_autorizacion = "<center><input type='checkbox' name='autorizacion' id='autorizacion' $autorizacion onchange='autorizacion($row_incidencias[0])'></center>";
    $tiempo = $row_incidencias[4];
    // $tiempo = substr($tiempo,0,5);

    $cadena_persona = "SELECT nombre, ap_paterno, ap_materno FROM empleados WHERE codigo = '$row_incidencias[1]'";
    $consulta_persona = sqlsrv_query($conn, $cadena_persona);
    $row_persona = sqlsrv_fetch_array( $consulta_persona, SQLSRV_FETCH_ASSOC);
    $nombre_empleado = $row_persona['nombre'].' '.$row_persona['ap_paterno'].' '.$row_persona['ap_materno'];
    $nombre_empleado=ucwords(strtolower($nombre_empleado));
    $empleado = $row_incidencias[1].' - '.$nombre_empleado; 
    
    $renglon = "
      {
      \"id\":           \"$editar\",
      \"nombre\":       \"$empleado\",
      \"departamento\": \"$departamento\",
      \"sucursal\":     \"$sucursal\",
      \"autoriza\":     \"$row_incidencias[7]\",
      \"motivo\":       \"$row_incidencias[8]\",
      \"tiempo\":       \"$tiempo\",
      \"comentario\":   \"$row_incidencias[5]\",
      \"fecha\":        \"$row_incidencias[6]\"
    },";
    $cuerpo = $cuerpo.$renglon;
  }
  $cuerpo2 = trim($cuerpo,','); ///Quitarle la coma
  $tabla = "
  ["
  .$cuerpo2.
  "]
  ";
echo $tabla;
 ?>
