<?php
  include '../global_settings/conexion.php';
  include '../global_settings/consulta_sqlsrvr.php';
include '../global_seguridad/verificar_sesion.php'; 

$fecIni = $_POST["fecha_inicial"];
$fecFin = str_replace("-","",$_POST["fecha_final"]);
$parametro = $_POST['parametro'];
$fecha      = date('Y-m-d');
$prim_dia   = date('Y-m-01');



if($parametro==0){
  $fechaInicioLW = $prim_dia;
  $fechaFinLW = $fecha;
}else{
  $fechaInicioLW = $fecIni;
  $fechaFinLW = $fecFin;
}


$solo_suc = ($solo_sucursal == '1') ? " AND i.sucursal2='$id_sede'" : "";
  $nombre_empleado="";
  $sucursal="";
  $departamento="";

  $cadena  = "SELECT
                i.id,
                i.nombre,
                i.sucursal,
                i.departamento,
                ci.incidencia,
                i.folio,
                i.activo,
                i.comentario,
                i.perfil,
                i.usuario,
              CONCAT(p.nombre,' ',p.ap_paterno,' ', p.ap_materno),
              perfil.nombre,
              DATE_FORMAT(i.fecha,'%d/%m/%Y'),
              i.empleado
                FROM incidencias i INNER JOIN catalogo_incidencias ci, personas p, perfil, usuarios
                WHERE i.incidencia= ci.id AND i.activo='1'AND folio >'0' and i.usuario=usuarios.id and p.id=usuarios.id_persona and perfil.id=i.perfil  and( i.fecha between '$fechaInicioLW' and '$fechaFinLW')".$solo_suc;
              //  sucursal2='$id_sede'
//echo $cadena;
  $consulta = mysqli_query($conexion, $cadena);
  $cuerpo         = "";
  $texto = "";
  $color="";
  while ($row_incidencias = mysqli_fetch_array($consulta)) 
  {

    if ($row_incidencias[5] == "1")
    {
      $autorizar = "<center><span class='label label-success'>Autorizada</span></center>";
    }
    else if($row_incidencias[5] == "2")
    {
      $autorizar = "<center><span class='label label-danger'>Rechazada</span></center>";
    }else if($row_incidencias[5] == "8")
    {
      $autorizar = "<center><span class='label label-info'>Liberada</span></center>";
    }
    
    $autorizacion = ($row_incidencias[6]=="0") ? "" : "checked";
    $editar = "<center><a href='#' onclick='editar($row_incidencias[0])'>$row_incidencias[0]</a></center>";
    $sucursal=ucwords(strtolower($row_incidencias[2]));
    $departamento=ucwords(strtolower($row_incidencias[3]));
    if($row_incidencias[13]==null){
      $cadena_persona = "SELECT nombre, ap_paterno, ap_materno FROM empleados WHERE codigo = '$row_incidencias[1]'";
      $consulta_persona = sqlsrv_query($conn, $cadena_persona);
      $row_persona = sqlsrv_fetch_array( $consulta_persona, SQLSRV_FETCH_ASSOC);
      $nombre_empleado = $row_persona['nombre'].' '.$row_persona['ap_paterno'].' '.$row_persona['ap_materno'];
      $nombre_empleado=ucwords(strtolower($nombre_empleado));
      $empleado = $row_incidencias[1].' - '.$nombre_empleado;
    }else{
      $empleado = $row_incidencias[1].' - '.$row_incidencias[13];
    }
   
    $incidencia=mysqli_real_escape_string($conexion,$row_incidencias[4]);
    $comentario=mysqli_real_escape_string($conexion,$row_incidencias[7]);

    $renglon = "
      {
      \"id\": \"$editar\",
      \"nombre\": \"$empleado\",
      \"sucursal\": \"$sucursal\",
      \"departamento\": \"$departamento\",
      \"incidencia\": \"$incidencia\",
      \"fecha\": \"$row_incidencias[12]\",
      \"autoriza\": \"$row_incidencias[10]\",
      \"perfil\": \"$row_incidencias[11]\",
      \"comentario\": \"$comentario\",
      \"activo\": \"$autorizar\"
      },";
    $cuerpo = $cuerpo.$renglon;
    $texto = "";
  }
  $cuerpo2 = trim($cuerpo,','); ///Quitarle la coma
  $tabla = "
  ["
  .$cuerpo2.
  "]
  ";
  echo $tabla;
 ?>