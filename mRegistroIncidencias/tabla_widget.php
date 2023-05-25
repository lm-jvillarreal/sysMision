<?php
  include '../global_settings/conexion.php';
  include '../global_settings/consulta_sqlsrvr.php';
include '../global_seguridad/verificar_sesion.php'; 

//$solo_suc = ($solo_sucursal == '1') ? " AND i.sucursal2='$id_sede'" : "";
  $lugar = $_POST['lugar'];
  $dateI = $_POST['dateI'];
  $dateF = $_POST['dateF'];
//echo $lugar;
  $filtro = "";
  // $sucursal="";
  // $departamento="";
  if($lugar == '1')
  {
    $filtro = " AND sucursal = 'DIAZ ORDAZ'";
  }else if($lugar == '2')
  {
    $filtro = " AND sucursal = 'ARBOLEDAS'";
  }else if($lugar == '3')
  {
    $filtro = " AND sucursal = 'VILLEGAS'";
  }else if($lugar == '4')
  {
    $filtro = " AND sucursal = 'ALLENDE'";
  }else if($lugar == '5')
  {
    $filtro = " AND sucursal = 'PETACA'";
  }
  else if($lugar == '6')
  {
    $filtro = " AND sucursal = 'MONTEMORELOS'";
  }else if($lugar == '99')
  {
    $filtro = " AND sucursal = 'CEDIS'";
  }else if($lugar == '100'){
    $filtro = " AND sucursal = 'ADMINISTRACION'";
  }else {$filtro ="";}

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
DATE_FORMAT(i.fecha,'%d/%m/%Y')
  FROM incidencias i INNER JOIN catalogo_incidencias ci, personas p, perfil, usuarios
  WHERE  i.fecha BETWEEN CAST('$dateI' AS DATE)
              AND CAST('$dateF' AS DATE) AND i.incidencia= ci.id AND i.activo='1' and i.usuario=usuarios.id and p.id=usuarios.id_persona and perfil.id=i.perfil AND i.empleado IS NULL".$filtro;
//  sucursal2='$id_sede'
  $consulta = mysqli_query($conexion, $cadena);
  //echo $cadena;
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
    }else if($row_incidencias[5] == "0")
    {
      $autorizar = "<center><span class='label label-warning'>Pendiente</span></center>";
    }
    
    $autorizacion = ($row_incidencias[6]=="0") ? "" : "checked";
    $editar = "<center><a href='#' onclick='editar($row_incidencias[0])'>$row_incidencias[0]</a></center>";
    $sucursal=ucwords(strtolower($row_incidencias[2]));
    $departamento=ucwords(strtolower($row_incidencias[3]));

    $cadena_persona = "SELECT nombre, ap_paterno, ap_materno FROM empleados WHERE codigo = '$row_incidencias[1]'";
    $consulta_persona = sqlsrv_query($conn, $cadena_persona);
    $row_persona = sqlsrv_fetch_array( $consulta_persona, SQLSRV_FETCH_ASSOC);
    $nombre_empleado = $row_persona['nombre'].' '.$row_persona['ap_paterno'].' '.$row_persona['ap_materno'];
    $nombre_empleado=ucwords(strtolower($nombre_empleado));
    $empleado = $row_incidencias[1].' - '.$nombre_empleado;
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