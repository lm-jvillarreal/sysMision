<?php
  include '../global_settings/conexion.php';
  include '../global_settings/consulta_sqlsrvr.php';
include '../global_seguridad/verificar_sesion.php'; 

$solo_suc = ($solo_sucursal == '1') ? " AND sucursal='$id_sede'" : "";
  $nombre_empleado="";
  $sucursal="";
  $departamento="";

  $cadena  = "SELECT id, 
                      empleado, 
                      departamento, 
                      sucursal, 
                      turno_actual, 
                      turno_nuevo, 
                      horario_inicio, 
                      horario_final, 
                      comentario, 
                      estatus, 
                      usuario, 
                      autoriza,
                      (SELECT CONCAT(nombre,' ',ap_paterno,' ',ap_materno) FROM usuarios INNER JOIN personas ON personas.id = usuarios.id_persona WHERE usuarios.id = cambio_turnoSistemas.usuario),
                      (SELECT CONCAT(nombre,' ',ap_paterno,' ',ap_materno) FROM usuarios INNER JOIN personas ON personas.id = usuarios.id_persona WHERE usuarios.id = cambio_turnoSistemas.autoriza)
              FROM cambio_turnoSistemas WHERE ACTIVO = '1'".$solo_suc;
  //DATE_FORMAT(horario.fecha, '%d/%m/%Y')

  //  sucursal2='$id_sede'
  $consulta = mysqli_query($conexion, $cadena);
  //echo $cadena;
  $cuerpo         = "";
  $texto = "";
  $color="";
  while ($row_horario = mysqli_fetch_array($consulta)) 
  {
    $cadena_perfil="SELECT id, id_perfil from usuarios where activo = '1'";
    $consulta_perfil = mysqli_query($conexion, $cadena_perfil);
    $row_perfil = mysqli_fetch_array($consulta_perfil);
    if($row_perfil[1]==1){
      $autorizar = "<center><a href='#' onclick='autorizar($row_horario[0])' class='btn btn-aqua'><i class='fa fa-check fa-lg'></a></center>";
    }else{
      $autorizar = "<center><a href='#' disabled class='btn btn-aqua'><i class='fa fa-check fa-lg'></a></center>";
    }
    if($row_horario[3] == '1'){
      $sucursal2 ='DIAZ ORDAZ';
  }else if($row_horario[3] == '2'){
      $sucursal2 = 'ARBOLEDAS';
  }else if($row_horario[3] == '3'){
      $sucursal2 = 'VILLEGAS';
  }else if($row_horario[3] == '4'){
      $sucursal2 = 'ALLENDE';
  }else if($row_horario[3] == '5'){
      $sucursal2 = 'PETACA';
  }else if($row_horario[3] == '99'){
      $sucursal2 = 'CEDIS';
  }else{
      $sucursal2 = 'ADMINISTRACION';
  }
    
    
    $autorizacion = ($row_horario[6]=="0") ? "" : "checked";
    $editar = "<center><a href='#' onclick='editar($row_horario[0])'>$row_horario[0]</a></center>";
    $sucursal=ucwords(strtolower($sucursal2));
    $departamento=ucwords(strtolower($row_horario[2]));

    $cadena_persona = "SELECT nombre, ap_paterno, ap_materno FROM empleados WHERE codigo = '$row_horario[1]'";
    $consulta_persona = sqlsrv_query($conn, $cadena_persona);
    $row_persona = sqlsrv_fetch_array( $consulta_persona, SQLSRV_FETCH_ASSOC);
    $nombre_empleado = $row_persona['nombre'].' '.$row_persona['ap_paterno'].' '.$row_persona['ap_materno'];
    $nombre_empleado=ucwords(strtolower($nombre_empleado));
    $empleado = $row_horario[1].' - '.$nombre_empleado;
    $incidencia=mysqli_real_escape_string($conexion,$row_horario[4]);
    $comentario=mysqli_real_escape_string($conexion,$row_horario[8]);
    $date = substr($row_horario[6],0,10);
    $tiempo1 = substr($row_horario[6],10,9);
    $tiempo2 = substr($row_horario[7],10,9);
    $horario =mysqli_real_escape_string($conexion,$date."<br>".$tiempo1."&nbsp;".$tiempo2);

    $renglon = "
      {
      \"id\": \"$row_horario[0]\",
      \"nombre\": \"$empleado\",
      \"sucursal\": \"$sucursal2\",
      \"turno_actual\": \"$row_horario[4]\",
      \"turno_nuevo\": \"$row_horario[5]\",
      \"horario\": \"$horario\",
      \"comentario\": \"$comentario\",
      \"registra\": \"$row_horario[12]\",
      \"activo\": \"$row_horario[13]\"
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