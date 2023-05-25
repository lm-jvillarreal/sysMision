<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/consulta_sqlsrvr.php';
date_default_timezone_set('America/Monterrey');

$fecha=date("Y-m-d"); 
$hora=date ("H:i:s");

  $id_registro  = $_POST['id_registro'];
  $nombre       = $_POST['id_persona'];
  $departamento = $_POST['departamento'];
  $sucursal     = $_POST['sucursal'];
  $categoria    = $_POST['categoria'];
  $incidencia   = $_POST['incidencia'];
  $comentario   = $_POST['comentario'];
  $accion       = $_POST['accion'];
  $firma        = $_POST['clave']; 
  $vigilante    = $_POST['vigilante'];

$comentario_cancelar = "Registro cancelado"; 
  if (empty($id_registro)) {

    //Insertar nuevo registro
    //inserta registros textuales,ligado a bd de sql, no se liga por id a tablas de mysql
    $verificar=mysqli_query($conexion,"SELECT id FROM incidencias WHERE id= '$id_registro'");
    $existe = mysqli_num_rows($verificar);

    if($existe == 0){
      //se inserta con folio '3' para identificar que se canceló en el registro.
      $cadena_insertar = "INSERT INTO incidencias (nombre,departamento,sucursal,incidencia,fecha,hora,activo, usuario, folio, comentario, categoria, accion, autorizacion, comentario_fin, vigilante)
      VALUES('$nombre','$departamento','$sucursal','$incidencia','$fecha','$hora', '1', '$id_usuario', '3','$comentario', '$categoria','$accion','1','$comentario_cancelar','$vigilante')";
       $insertar_registro = mysqli_query($conexion,$cadena_insertar);
      echo "ok";
    }
    else{
      echo "";
    }
    
  }elseif (!empty($id_registro)) {
    $cadena_actualizar = "UPDATE incidencias SET nombre = '$nombre', departamento='$departamento',sucursal= '$sucursal',categoria='$categoria', incidencia='$incidencia', comentario='$comentario' WHERE id = '$id_registro' accion='$accion'";
    //$consulta_actualizar = mysqli_query($conexion, $cadena_actualizar);
    echo "actualizado";
  }
?>