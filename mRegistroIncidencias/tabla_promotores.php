<?php
  include '../global_settings/conexion.php';
  include '../global_seguridad/verificar_sesion.php';
  //include '../global_settings/consulta_sqlsrvr.php';
  $solo_suc = ($solo_sucursal == '1') ? " AND incidencias.sucursal2='$id_sede'" : "";
$filtro_registros_propios = ($registros_propios=="0") ? "" : " AND i.usuario='$id_usuario'";

$departamento = "";
$nombre_empleado="";
$sucursal="";

$cadena  = "SELECT
incidencias.id,
incidencias.nombre,
promotores.compañia,
incidencias.sucursal,
incidencias.activo,
incidencias.comentario,
catalogo_incidencias.incidencia,
categorias.categoria,
incidencias.folio,
incidencias.vigilante,
CONCAT(vidvig_vigilantes.NOMBRE,' ',vidvig_vigilantes.AP_PATERNO,' ',vidvig_vigilantes.AP_MATERNO),
incidencias.autorizacion,
CONCAT(promotores.nombre,' ',promotores.ap_paterno),
incidencias.tipo,
tipos_incidencias.tipo,
date_format(incidencias.fecha,'%d/%m/%Y')
FROM
incidencias,
catalogo_incidencias,
categorias,
vidvig_vigilantes,
promotores,
tipos_incidencias
WHERE
incidencias.categoria = categorias.id
and incidencias.nombre=promotores.id
AND incidencias.incidencia = catalogo_incidencias.id
and incidencias.tipo=tipos_incidencias.id
AND incidencias.activo = '1'
and incidencias.vigilante= vidvig_vigilantes.ID
and incidencias.folio <'3'".$solo_suc;//.$filtro_registros_propios;

  //modificar la consulta de la tabla para ligar registros con sql
  //modificar bd para agregar datos textules y no ligar por id con tablas de mySql        

  $consulta = mysqli_query($conexion, $cadena);
  $cuerpo         = "";


  while ($row_incidencias = mysqli_fetch_array($consulta)) 
  {
    //////////////////codigo para mostrar el check de autorizacion para gerentes/////////
    $cadena_perfil="SELECT id, id_perfil from usuarios where id_perfil = '11' or id_perfil = '9' or id = '2' or id= '161'";
    $consulta_perfil = mysqli_query($conexion, $cadena_perfil);
    $row_perfil = mysqli_fetch_array($consulta_perfil);

    if($row_perfil[1] == "1"){
      //cambiar el 1 por 11 de gerencia al terminar
      $autorizacion = ($row_incidencias[9]=="0") ? "" : "checked";
      $chk_autorizacion = "<center><input type='checkbox' name='autorizacion' id='autorizacion' $autorizacion onchange='autorizacion($row_incidencias[0])'></center>";
      
    }else{
      $chk_autorizacion ="<center><input type='checkbox' name='autorizacion' id='autorizacion' $autorizacion onchange='autorizacion' disabled></center>";
      
    }
    /////////////////////////////////gerencia///////////////////////////////////////////////

    //////////////////////////imprimir/////////////////////////////////////////////////

    if($row_incidencias[8]=="0")
    //0= pendiente 
    {
      if($row_incidencias[11]=="0"){
        //row 12 autorizacion = 0 : registra sin firma
        //no imprime, edita si se autoriza
        $imprimir = "<center><a href='#' class='btn btn-aqua'disabled><i class='fa fa-print fa-lg'></a></center>";
        $editar = "<center><a href='#' onclick='editarP($row_incidencias[0])'>$row_incidencias[0]</a></center>";
        $autorizar = "<a href='#' data-id = '$row_incidencias[0]' data-toggle = 'modal' data-target = '#modal-pagar' class='btn btn-success' target='blank'> <i class='fa fa-eye fa-lg'></i></a>";
      }else{
        //autorizacion 1: registra con firma
        //no imprime, no edita, si se autoriza
        $imprimir = "<center><a href='#' class='btn btn-aqua'disabled><i class='fa fa-print fa-lg'></a></center>";
        $editar = "<center><a href='#'disabled>$row_incidencias[0]</a></center>";
        $autorizar = "<a href='#' data-id = '$row_incidencias[0]' data-toggle = 'modal' data-target = '#modal-pagar' class='btn btn-success' target='blank'> <i class='fa fa-eye fa-lg'></i></a>";  
      }
    }else if($row_incidencias[8]=="1"){
      //1= autorizado
      //imprime, no edita, no se autoriza
      $imprimir = "<center><a href='#' onclick='imp_fichaP($row_incidencias[0])'class='btn btn-aqua' ><i class='fa fa-print fa-lg'></i></a></center>";
      $editar = "<center><a href='#'disabled>$row_incidencias[0]</a></center>";
      $autorizar = "<a href='#' data-id = '$row_incidencias[0]' data-toggle = 'modal' data-target = '#modal-pagar' class='btn btn-success disabled' target='blank'> <i class='fa fa-eye fa-lg'></i></a>";
    }else if($row_incidencias[8]=="2"){
      //2= rechazado
      //no imprime, no edita, no se autoriza
      $imprimir = "<center><a href='#' class='btn btn-aqua'disabled><i class='fa fa-print fa-lg'></a></center>";
      $editar = "<center><a href='#'disabled>$row_incidencias[0]</a></center>";
      $autorizar = "<a href='#' data-id = '$row_incidencias[0]' data-toggle = 'modal' data-target = '#modal-pagar' class='btn btn-success disabled' target='blank'> <i class='fa fa-eye fa-lg'></i></a>";
    }
    ////////////////////////imprimir//////////////////////////////////////////////////
    
     
    ///////////////////////////////////tabla/////////////////////////////////////////////
    $activo = ($row_incidencias[4]=="0") ? "" : "checked";
    $departamento =ucfirst(strtolower($row_incidencias[4]));
    $sucursal=ucfirst(strtolower($row_incidencias[2]));
    
    if ($row_incidencias[8] == "0")
    {
      $estado = "<center><span class='label label-warning'>Pendiente</span></center>";
    }
    else if($row_incidencias[8] == "1")
    {
      $estado = "<center><span class='label label-success'>Autorizada</span></center>";
    }
    else
    {
      $estado = "<center><span class='label label-danger'>Rechazada</span></center>";
    }
    $escape_comentario = mysqli_real_escape_string($conexion,$row_incidencias[5]);
    $acciones= "<center>$autorizar</center>";
    $renglon = "
      {
      \"id\": \"$editar\",
      \"nombre\": \"$row_incidencias[12]\",
      \"compañia\": \"$row_incidencias[2]\",
      \"sucursal\": \"$row_incidencias[3]\",
      \"incidencia\": \"$row_incidencias[6]\",
      \"categoria\": \"$row_incidencias[7]\",
      \"tipo\": \"$row_incidencias[14]\",  
      \"comentario\": \"$escape_comentario\",
      \"vigilante\": \"$row_incidencias[10]\",
      \"fecha\": \"$row_incidencias[15]\",
      \"activo\": \"$estado\",
      \"autorizar\": \"$acciones\",
      \"imprimir\": \"\"
      },";
    $cuerpo = $cuerpo.$renglon;
    $departamento="";
    $nombre_empleado="";
  }
  $cuerpo2 = trim($cuerpo,','); ///Quitarle la coma
  $tabla = "
  ["
  .$cuerpo2.
  "]
  ";
  echo $tabla;
 ?>