<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set('America/Monterrey');

$fecha=date("Y-m-d"); 
$hora=date ("H:i:s");

  $id_registro  = $_POST['id_registroo'];
  $nombre       = $_POST['id_promotor'];
  $compañia = $_POST['compañia'];
  $categoria    = $_POST['categoriaP'];
  $incidencia   = $_POST['incidenciaP'];
  $comentario   = $_POST['comentarioP'];
  $accion       = $_POST['accionP'];
  $firma        = $_POST['claveP']; 
  $vigilante    = $_POST['vigilanteP'];

$comentario_cancelar = "Registro cancelado"; 
  if (empty($id_registro)) {

    //Insertar nuevo registro
    //inserta registros textuales,ligado a bd de sql, no se liga por id a tablas de mysql
    $verificar=mysqli_query($conexion,"SELECT id FROM incidencias WHERE id= '$id_registro'");
    $existe = mysqli_num_rows($verificar);

    if($existe == 0){
      //se inserta con folio '3' para identificar que se canceló en el registro.
      $cadena_insertar = "INSERT INTO incidencias (nombre,departamento,sucursal,incidencia,fecha,hora,activo, usuario, folio, comentario, categoria, accion, autorizacion, comentario_fin, vigilante, perfil)
      VALUES('$nombre','$compañia','','$incidencia','$fecha','$hora', '1', '$id_usuario', '3','$comentario', '$categoria','$accion','1','$comentario_cancelar','$vigilante','2')";
       $insertar_registro = mysqli_query($conexion,$cadena_insertar);
      echo "ok";
    }
    else{
      echo "";
    }
    
  }elseif (!empty($id_registro)) {
    $cadena_actualizar = "UPDATE incidencias SET nombre = '$nombre', departamento='$compañia',categoria='$categoria', incidencia='$incidencia', comentario='$comentario' WHERE id = '$id_registro' accion='$accion'";
    //$consulta_actualizar = mysqli_query($conexion, $cadena_actualizar);
    echo "actualizado";
  }
?>