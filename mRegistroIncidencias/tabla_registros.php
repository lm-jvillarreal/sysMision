<?php
include '../global_seguridad/verificar_sesion.php';
  include '../global_settings/conexion.php';
  include '../global_settings/consulta_sqlsrvr.php';


  $solo_suc = ($solo_sucursal == '1') ? " AND incidencias.sucursal2='$id_sede'" : "";
$idUsr = $_POST['idUsr'];
$ide=$_GET['ide'];
$departamento = "";
$nombre_empleado="";
$sucursal="";
$datos = array();

$cadena  = "SELECT
incidencias.id,
incidencias.nombre,
incidencias.departamento,
incidencias.incidencia,
incidencias.sucursal,
incidencias.activo,
incidencias.comentario,
catalogo_incidencias.incidencia,
categorias.categoria,
incidencias.folio,
incidencias.vigilante,
CONCAT(vidvig_vigilantes.NOMBRE,' ',vidvig_vigilantes.AP_PATERNO,' ',vidvig_vigilantes.AP_MATERNO),
incidencias.autorizacion,
incidencias.tipo,
tipos_incidencias.tipo,
DATE_FORMAT(incidencias.fecha, '%d/%m/%Y')
FROM
incidencias,
catalogo_incidencias,
categorias,
vidvig_vigilantes,
tipos_incidencias
WHERE
incidencias.categoria = categorias.id 
AND incidencias.incidencia = catalogo_incidencias.id 
AND incidencias.activo = '1'
and incidencias.vigilante= vidvig_vigilantes.ID
and incidencias.folio = 0
and incidencias.tipo=tipos_incidencias.id
and incidencias.autorizacion != '2'
".$solo_suc;
// and incidencias.sucursal2 = '$id_sede'
  $consulta = mysqli_query($conexion, $cadena);
  $cuerpo         = "";


  while ($row_incidencias = mysqli_fetch_array($consulta)) 
  {
    //////////////////codigo para mostrar el check de autorizacion para gerentes/////////
    $cadena_perfil="SELECT id, id_perfil from usuarios where activo = '1'";
    // id_perfil = '2' or id_perfil = '9' 
    $consulta_perfil = mysqli_query($conexion, $cadena_perfil);
    // id_perfil = '2' or
    $row_perfil = mysqli_fetch_array($consulta_perfil);

    // if($row_perfil[1] == "9"){
      //cambiar el 1 por 2 de gerencia al terminar
      if($row_incidencias[9]=="0")
        //0= pendiente 
      {
        if($row_incidencias[12]=="0"){
            //row 12 autorizacion = 0 : registra sin firma
            //no imprime, edita si se autoriza
            $imprimir = "<center><a href='#' class='btn btn-aqua'disabled><i class='fa fa-print fa-lg'></a></center>";
            $editar = "<center><a href='#' onclick='editar($row_incidencias[0])'>$row_incidencias[0]</a></center>";
            $autorizar = "<a href='#' data-id = '$row_incidencias[0]' data-toggle = 'modal' data-target = '#modal-pagar' class='btn btn-success' target='blank'> <i class='fa fa-eye fa-lg'></i></a>";
          }else
          {
            //autorizacion 1: registra con firma
            //no imprime, no edita, si se autoriza
            $imprimir = "<center><a href='#' class='btn btn-aqua'disabled><i class='fa fa-print fa-lg'></a></center>";
            $editar = "<center><a href='#'disabled>$row_incidencias[0]</a></center>";
            $autorizar = "<a href='#' data-id = '$row_incidencias[0]' data-toggle = 'modal' data-target = '#modal-pagar' class='btn btn-success' target='blank'> <i class='fa fa-eye fa-lg'></i></a>";  
          }
      }else if($row_incidencias[9]=="1")
        {
          //1= autorizado
          //imprime, no edita, no se autoriza
          $imprimir = "<center><a href='#' onclick='imp_ficha($row_incidencias[0])'class='btn btn-aqua' ><i class='fa fa-print fa-lg'></i></a></center>";
          $editar = "<center><a href='#'disabled>$row_incidencias[0]</a></center>";
          $autorizar = "<a href='#' data-id = '$row_incidencias[0]' data-toggle = 'modal' data-target = '#modal-pagar' class='btn btn-success disabled' target='blank'> <i class='fa fa-eye fa-lg'></i></a>";
        }else if($row_incidencias[9]=="2")
        {
          //2= rechazado
          //no imprime, no edita, no se autoriza
          $imprimir = "<center><a href='#' class='btn btn-aqua'disabled><i class='fa fa-print fa-lg'></a></center>";
          $editar = "<center><a href='#'disabled>$row_incidencias[0]</a></center>";
          $autorizar = "<a href='#' data-id = '$row_incidencias[0]' data-toggle = 'modal' data-target = '#modal-pagar' class='btn btn-success disabled' target='blank'> <i class='fa fa-eye fa-lg'></i></a>";
        }
        else if($row_incidencias[9]=="8"){
          //8= liberado
          //imprime, no edita, no se autoriza
          $imprimir = "<center><a href='#' onclick='imp_ficha($row_incidencias[0])'class='btn btn-aqua' ><i class='fa fa-print fa-lg'></i></a></center>";
          $editar = "<center><a href='#'disabled>$row_incidencias[0]</a></center>";
          $autorizar = "<a href='#' data-id = '$row_incidencias[0]' data-toggle = 'modal' data-target = '#modal-pagar' class='btn btn-success disabled' target='blank'> <i class='fa fa-eye fa-lg'></i></a>";
        }
        
     if($row_perfil[1] == "9"){
      
      if($row_incidencias[9]=="0")
      //0= pendiente 
      {
        if($row_incidencias[12]=="0"){
          //row 12 autorizacion = 0 : registra sin firma
          //no imprime, edita si se autoriza
          $imprimir = "<center><a href='#' class='btn btn-aqua'disabled><i class='fa fa-print fa-lg'></a></center>";
          $editar = "<center><a href='#' onclick='editar($row_incidencias[0])'>$row_incidencias[0]</a></center>";
          $autorizar = "<a href='#' data-id = '$row_incidencias[0]' data-toggle = 'modal' data-target = '#modal-pagar' class='btn btn-success disabled' target='blank'> <i class='fa fa-eye fa-lg'></i></a>";
        }else{
          //autorizacion 1: registra con firma
          //no imprime, no edita, si se autoriza
          $imprimir = "<center><a href='#' class='btn btn-aqua'disabled><i class='fa fa-print fa-lg'></a></center>";
          $editar = "<center><a href='#'disabled>$row_incidencias[0]</a></center>";
          $autorizar = "<a href='#' data-id = '$row_incidencias[0]' data-toggle = 'modal' data-target = '#modal-pagar' class='btn btn-success disabled' target='blank'> <i class='fa fa-eye fa-lg'></i></a>";
        }
      }else if($row_incidencias[9]=="1"){
        //1= autorizado
        //imprime, no edita, no se autoriza
        $imprimir = "<center><a href='#' onclick='imp_ficha($row_incidencias[0])'class='btn btn-aqua' ><i class='fa fa-print fa-lg'></i></a></center>";
        $editar = "<center><a href='#'disabled>$row_incidencias[0]</a></center>";
        $autorizar = "<a href='#' data-id = '$row_incidencias[0]' data-toggle = 'modal' data-target = '#modal-pagar' class='btn btn-success disabled' target='blank'> <i class='fa fa-eye fa-lg'></i></a>";
      }else if($row_incidencias[9]=="2"){
        //2= rechazado
        //no imprime, no edita, no se autoriza
        $imprimir = "<center><a href='#' class='btn btn-aqua'disabled><i class='fa fa-print fa-lg'></a></center>";
        $editar = "<center><a href='#'disabled>$row_incidencias[0]</a></center>";
        $autorizar = "<a href='#' data-id = '$row_incidencias[0]' data-toggle = 'modal' data-target = '#modal-pagar' class='btn btn-success disabled' target='blank'> <i class='fa fa-eye fa-lg'></i></a>";
      }else if($row_incidencias[9]=="8"){
        //8= liberado
        //imprime, no edita, no se autoriza
        $imprimir = "<center><a href='#' onclick='imp_ficha($row_incidencias[0])'class='btn btn-aqua' ><i class='fa fa-print fa-lg'></i></a></center>";
        $editar = "<center><a href='#'disabled>$row_incidencias[0]</a></center>";
        $autorizar = "<a href='#' data-id = '$row_incidencias[0]' data-toggle = 'modal' data-target = '#modal-pagar' class='btn btn-success disabled' target='blank'> <i class='fa fa-eye fa-lg'></i></a>";
      }
    }
    //////////////////////////vigilancia/////////////////////////////////////////////////

    
    ///////////////////////////////////tabla/////////////////////////////////////////////
    $activo = ($row_incidencias[4]=="0") ? "" : "checked";
    $departamento =ucfirst(strtolower($row_incidencias[4]));
    $sucursal=ucfirst(strtolower($row_incidencias[2]));
    
    if ($row_incidencias[9] == "0")
    {
      $estado = "<center><span class='label label-warning'>Pendiente</span></center>";
    }
    else if($row_incidencias[9] == "1")
    {
      $estado = "<center><span class='label label-success'>Autorizada</span></center>";
    }
    else if($row_incidencias[9] == "8")
    {
      $estado = "<center><span class='label label-info'>Liberada</span></center>";
    }
   

    $cadena_persona = "SELECT nombre, ap_paterno, ap_materno FROM empleados WHERE codigo = '$row_incidencias[1]'";
    $consulta_persona = sqlsrv_query($conn, $cadena_persona);
    $row_persona = sqlsrv_fetch_array( $consulta_persona, SQLSRV_FETCH_ASSOC);
    $nombre_empleado = $row_persona['nombre'].' '.$row_persona['ap_paterno'].' '.$row_persona['ap_materno']; 
    $nombre_empleado=ucwords(strtolower($nombre_empleado));
    $empleado = $row_incidencias[1].' - '.$nombre_empleado; 
    $acciones= "<center>$autorizar</center>";
    if($row_incidencias[12]=='1'){
      $firma = "<a href='#' data-id = '$row_incidencias[0]' data-toggle = 'modal' data-target = '#' class='btn btn-default' disabled > <i class='fa fa-check fa-lg'></i></a>";
      //$firma = "Firmado";
    }else if( $row_incidencias[12]=='0'){
      //$firma ="<a href='#' data-id = '$row_incidencias[0]' data-toggle = 'modal' data-target = '#modal-default2' class='btn btn-default' target='blank'> <i class='fa fa-pencil fa-lg'></i></a>";
      $firma = "<a href='#' data-id = '$row_incidencias[0]' data-toggle = 'modal' data-target = '#modal-firmar' class='btn btn-default' target='blank'> <i class='fa fa-pencil fa-lg'></i></a>";  
      //$firma = "<a href='#' data-id = '$row_incidencias[0]' data-toggle = 'modal' data-target = '#modal-default' class='btn btn-default'> <i class='fa fa-pencil fa-lg'></i></a>";
      //$firma = "<center><a href='#' onclick='firma($row_incidencias[0])'class='btn btn-default'><i class='fa fa-pencil fa-lg'></i></a></center>";
      //$firma = "<a href='#' data-id = '$row_incidencias[0]' data-toggle = 'modal' data-target = '#modal-default2' class='btn btn-default' target='blank'> <i class='fa fa-pencil fa-lg'></i></a>";
      //$firma = "Sin Firma";
    }

    $escape_comentario = mysqli_real_escape_string($conexion,$row_incidencias[6]);
    
    array_push($datos, array(
      'id'=>$editar,
      'nombre'=>$empleado,
      'departamento'=>$departamento,
      'sucursal'=>$sucursal,
      'incidencia'=>$row_incidencias[7],
      'categoria'=>$row_incidencias[8],
      'tipo'=>$row_incidencias[14],
      'comentario'=>$escape_comentario,
      'vigilante'=>$row_incidencias[11],
      'fecha'=>$row_incidencias[15],
      'activo'=>$estado,
      'firma'=>$firma,
      'autorizar'=>$acciones
    ));
    // $renglon = "
    //   {
    //   \"id\": \"$editar\",
    //   \"nombre\": \"$empleado\",
    //   \"departamento\": \"$departamento\",
    //   \"sucursal\": \"$sucursal\",
    //   \"incidencia\": \"$row_incidencias[7]\",
    //   \"categoria\": \"$row_incidencias[8]\", 
    //   \"tipo\": \"$row_incidencias[14]\",  
    //   \"comentario\": \"$escape_comentario\",
    //   \"vigilante\": \"$row_incidencias[11]\",
    //   \"fecha\": \"$row_incidencias[15]\",
    //   \"activo\": \"$estado\",
    //   \"firma\": \"$firma\",
    //   \"autorizar\": \"$acciones\",
    //   \"imprimir\": \"\"
    //   },";
    // $cuerpo = $cuerpo.$renglon;
    $departamento="";
    $nombre_empleado="";
  }
  // $cuerpo2 = trim($cuerpo,','); ///Quitarle la coma
  // $tabla = "
  // ["
  // .$cuerpo2.
  // "]
  // ";
  // echo $tabla;
  echo utf8_encode(json_encode($datos));
 ?>