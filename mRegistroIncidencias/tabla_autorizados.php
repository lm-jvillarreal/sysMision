<?php
// aimenta la tabla de monitoreo de incidencias
  include '../global_settings/conexion.php';
  include '../global_settings/consulta_sqlsrvr.php';
  include '../global_seguridad/verificar_sesion.php';

  $solo_suc = ($solo_sucursal == '1') ? " AND i.sucursal2='$id_sede'" : "";
  $nombre_empleado="";
  $departamento="";
  $sucursal="";

  $cadena  = "SELECT i.id,
  i.nombre,
  i.departamento,
  i.sucursal,
  ci.incidencia as incidencia,
  i.activo,
  i.folio,
  i.comentario,
  categorias.categoria,
  i.perfil,
  i.usuario,
  CONCAT(p.nombre,' ',p.ap_paterno,' ', p.ap_materno),
  perfil.nombre,
  i.vigilante,
  CONCAT(vv.NOMBRE,' ',vv.AP_PATERNO,' ',vv.AP_MATERNO),
  DATE_FORMAT(i.fecha,'%d/%m/%Y')
  FROM incidencias i INNER JOIN catalogo_incidencias ci, categorias, personas p, usuarios, perfil, vidvig_vigilantes vv
  WHERE i.incidencia= ci.id AND i.activo ='1'and i.categoria=categorias.id AND i.folio='1' and i.usuario=usuarios.id and p.id=usuarios.id_persona and perfil.id=i.perfil and i.vigilante = vv.ID".$solo_suc;
           
  $consulta = mysqli_query($conexion, $cadena);
  $cuerpo         = "";

  
  while ($row_incidencias = mysqli_fetch_array($consulta)) 
  {
    $cadena_perfil="SELECT id, id_perfil from usuarios where id_perfil = '17' or id_perfil = '9' or id = '2' or id= '161'";
    //id_perfil 17: monitoreo//id_perfil 9: vigilancia//id_2: erick //id_161 angie

  $consulta_perfil = mysqli_query($conexion, $cadena_perfil);
  $row_perfil = mysqli_fetch_array($consulta_perfil);
  if($row_perfil[1]=="17"){
    $chk_autorizacion = "<center><input type='checkbox' name='autorizacion' id='autorizacion' $autorizacion onchange='autorizacion($row_incidencias[0])'></center>";
  }else{
  }

    $activo = ($row_incidencias[4]=="0") ? "" : "checked";

    $ver = "<center><a href='PDF/pdfActaAdministrativa.php?id_registro=$row_incidencias[0]' class='btn btn-warning' target='blank'>Imprimir Acta</a></center>";
    // $subir="":http://200.1.1.197/SMPruebas/mRegistro_incidencias/
    if($row_incidencias[6]==1){
      $autorizar = "<center><span class='label label-success'>Autorizada</span></center>";
    }else if($row_incidencias[6]==8){
      $autorizar = "<center><span class='label label-success'>Liberada</span></center>";
    }else{

    }
    $editar = "<center><a href='#' onclick='editar($row_incidencias[0])'>$row_incidencias[0]</a></center>";
    $chk_activo = "<center><input type='checkbox' name='activo' id='activo' $activo onchange='estatus($row_incidencias[0])'></center>";
    $sucursal=ucwords(strtolower($row_incidencias[3]));
    $departamento=ucwords(strtolower($row_incidencias[2]));

    $imprimir = "<center><a href='#' onclick='imp_fichaP($row_incidencias[0])'class='btn btn-aqua' >$row_incidencias[0]</a></center>";
    $subir = "<center><a href='cargar_acta.php' class='btn btn-primary'>Subir Acta</a></center>";

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
      \"id\": \"$imprimir\",
      \"nombre\": \"$empleado\",
      \"departamento\": \"$departamento\",
      \"sucursal\": \"$sucursal\",
      \"incidencia\": \"$incidencia\",
      \"comentario\": \"$comentario\",
      \"registra\": \"$row_incidencias[14]\",
      \"fecha\": \"$row_incidencias[15]\",
      \"activo\": \"$autorizar\",
      \"autoriza\": \"$row_incidencias[11]\",
      \"perfil\": \"$row_incidencias[12]\",
      \"liberar\": \"$chk_autorizacion\"
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
 