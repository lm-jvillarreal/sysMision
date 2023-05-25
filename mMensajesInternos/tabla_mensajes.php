<?php
  include '../global_settings/conexion.php';
  include '../global_settings/consulta_sqlsrvr.php';
include '../global_seguridad/verificar_sesion.php'; 
$solo_suc = ($solo_sucursal == '1') ? " AND sucursal='$id_sede'" : "";
  $nombre_empleado="";
  $sucursal="";
  $departamento="";

$CadenaDatos = "SELECT 
                id,
                sucursal, 
                mensaje, 
                destinatario,
                (SELECT CONCAT(nombre, ' ', ap_paterno, ' ', ap_materno) FROM usuarios INNER JOIN personas ON personas.id = usuarios.id_persona WHERE usuarios.id = mensajes.id_usuario),
                (SELECT CONCAT(nombre, ' ', ap_paterno, ' ', ap_materno) FROM usuarios INNER JOIN personas ON personas.id = usuarios.id_persona WHERE usuarios.id_persona = mensajes.destinatario),
                area,
                id_usuario,
                estatus 
                FROM mensajes WHERE estatus = '0' AND activo = '1'".$solo_suc;
$consultaDatos = mysqli_query($conexion, $CadenaDatos);
  $cuerpo         = "";
  $texto = "";
  $color="";
  while ($row_mensaje = mysqli_fetch_array($consultaDatos)) 
  {
    if($row_mensaje[1] = 1){
      $Sucursal = "DIAZ ORDAZ";
    }else if($row_mensaje[1] = 2){
      $Sucursal = "ARBOLEDAS";
    }else if($row_mensaje[1] = 3){
      $Sucursal = "VILLEGAS";
    }else if($row_mensaje[1] = 4){
      $Sucursal = "ALLENDE";
    }else if($row_mensaje[1] = 5){
      $Sucursal = "PETACA";
    }else if($row_mensaje[1] = 99){
      $Sucursal = "CEDIS";
    }
    $numero = 1;
    $responder = "<a href='#' data-id = '$row_mensaje[0]' data-toggle = 'modal' data-target = '#modal-pagar' class='btn btn-success' target='blank'> <i class='fa fa-eye fa-lg'></i></a>";
    $editar = "<center><a href='#' onclick='editar($row_mensaje[0])'>$row_mensaje[0]</a></center>";
    $sucursal=ucwords(strtolower($Sucursal));
    $mensaje=mysqli_real_escape_string($conexion,$row_mensaje[2]);
    $area=mysqli_real_escape_string($conexion,$row_mensaje[6]);
    //$autorizar = "<div class='input-group' style='width:100%''><input type='text' id='$row_mensaje[0]' class='form-control'><span class='input-group-btn'><button id='btn_autorizar$numero' onclick='autorizar($row_incidencias[0],$row_incidencias[8],$numero)' class='btn btn-danger' type='button'><i class='fa fa-floppy-o fa-lg' aria-hidden='true'></i></button></span></div> <input type='hidden'value='$tiempo' id='tiempo$numero'>";
    $inputPiezas = "<div class='input-group' style='width:100%''><input type='text' class='form-control' value=''></input><span class='input-group-btn'><button id='btn_autorizar$numero' onclick='autorizar($row_mensaje[0],$row_mensaje[7],$numero)' class='btn btn-danger' type='button'><i class='fa fa-floppy-o fa-lg' aria-hidden='true'></i></button></span></div>";
  //  if(){
    
  //  }
    $Audio = "<center><a href='#' class='btn btn-warning'onclick ='subirAudio($row_mensaje[0])'><i class='fa fa-cloud-upload fa-lg' aria-hidden='true'></i></a></center>";
    $Imagenes = "<center><a href='#' class='btn btn-danger'onclick ='subirImagen($row_mensaje[0])'><i class='fa fa-camera fa-lg' aria-hidden='true'></i></a></center>";
    $autorizacion = ($row_mensaje[6]=="0") ? "" : "checked";
   
    $renglon = "
      {
      \"id\": \"$editar\",
      \"sucursal\": \"$sucursal\",
      \"usuario\": \"$row_mensaje[4]\",
      \"destinatario\": \"$row_mensaje[5]\",
      \"area\": \"$row_mensaje[6]\",
      \"mensaje\": \"$mensaje\",
      \"audio\": \"$Audio\",
      \"fotos\": \"$Imagenes\",
      \"responder\": \"$inputPiezas\"
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
  // fa-photo
  // <!-- fa-camera
  // fa-cloud-upload
  // fa-volume-up
  // fa-play-circle -->
 ?>
