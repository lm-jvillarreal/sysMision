<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/consulta_sqlsrvr.php';
date_default_timezone_set('America/Monterrey');

$fecha=date("Y-m-d"); 
$hora=date ("H:i:s");
$fechahora=date("Y-m-d H:i:s");
$nuevafecha  = strtotime ( '+1 day' , strtotime ( $fecha_nueva ) ) ;
$nuevafecha  = date ( 'Y-m-d' , $nuevafecha );


  $id_registro  = $_POST['id_registro'];
  $nombre       = $_POST['id_persona'];
  $departamento = $_POST['departamento'];
  $sucursal     = $_POST['sucursal'];
  $datetimeIn    = $_POST['fecha_inicio'];
  $datetimeFin         = $_POST['fecha_final'];
  $horario   = $_POST['horario'];
  $horarioA   = $_POST['horarioA'];
  $comentario   = $_POST['comentario'];

  if($horario == 'Mañana'){
    $horarioNuevo = 'Tarde';
  }else{
    $horarioNuevo='Mañana';
  }
 
if($sucursal == 'DIAZ ORDAZ'){
    $sucursal2 ='1';
}else if($sucursal == 'ARBOLEDAS'){
    $sucursal2 = '2';
}else if($sucursal == 'VILLEGAS'){
    $sucursal2 = '3';
}else if($sucursal == 'ALLENDE'){
    $sucursal2 = '4';
}else if($sucursal == 'PETACA'){
    $sucursal2 = '5';
}else if($sucursal == 'CEDIS'){
    $sucursal2 = '99';
}else if ($sucursal == 'ADMINISTRACION'){
    $sucursal2 = '1';
}
  if (empty($id_registro)) {
      $cadena_perfil = "SELECT
      usuarios.id_perfil, usuarios.id_persona, CONCAT(p.nombre,' ',p.ap_paterno,' ',p.ap_materno) FROM usuarios INNER JOIN personas p ON p.id=usuarios.id_persona WHERE usuarios.activo = '1'and usuarios.id='$id_usuario'";
      $consulta_perfil =mysqli_query($conexion, $cadena_perfil);
      $row_perfil=mysqli_fetch_array($consulta_perfil);
      $perfil = $row_perfil[0];

    //Insertar nuevo registro
    //inserta registros textuales,ligado a bd de sql, no se liga por id a tablas de mysql
    $verificar=mysqli_query($conexion,"SELECT id FROM cambio_turnoSistemas WHERE id= '$id_registro'");
    $existe = mysqli_num_rows($verificar);


    if($existe == 0){
        //se registra con autorizacion 1 porque el empleado est'a firmando el reporte
        //para insertar sin firma se envia la informacion al archivo insertar sin firma
      $cadena_insertar = "INSERT INTO cambio_turnoSistemas (empleado,departamento,sucursal,turno_actual,turno_nuevo,horario_inicio,horario_final,comentario,estatus,fechahora,usuario,autoriza,activo)
      VALUES('$nombre','$departamento','$sucursal2','$horarioA','$horario','$datetimeIn','$datetimeFin','$comentario','0','$fechahora','$id_usuario',null,'1')";
        $insertar_registro = mysqli_query($conexion,$cadena_insertar);
      echo "ok";
          /////////////////////////notificaciones///////////////////////////////////////////////
$cadena_agenda                = "";//consulta para insertar en la taba agenda
$fecha_completa_inicio = "";       //fecha inicial para insertar en agenda
$fecha_completa_final  = "";       //fecha final para insertar en agenda
$color = "#73C6B6";                //color para insertar en agenda
$fecha_nueva = date($fecha);
$nuevafecha  = strtotime ( '+1 day' , strtotime ( $fecha_nueva ) ) ;
$nuevafecha  = date ( 'Y-m-d' , $nuevafecha );

    $cadena_incidencias = mysqli_query($conexion,"SELECT id,empleado
                   FROM cambio_horarioSistemas
                   WHERE id = '$id_registro'");
 $row_incidencias = mysqli_fetch_array($cadena_incidencias);    

    function sanear_string($string)
    {
        $string = trim($string);
        $string = str_replace( array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
            $string
        );
        $string = str_replace(array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
            $string
        );
        $string = str_replace(array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
            $string
        );
        $string = str_replace(array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
            $string
        );
        $string = str_replace(array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
            $string
        );
        $string = str_replace(array('ñ', 'Ñ', 'ç', 'Ç'),array('n', 'N', 'c', 'C',),
            $string
        );
        return $string;
    }

  $title = sanear_string($nombre);
  if($id_sede == "1"){
      $sucu = "D.O";
  }else if($id_sede == "2"){
      $sucu = "ARB.";
  }else if ($id_sede == "3"){
      $sucu = "VILL.";
  }else if($id_sede == "4"){
     $sucu = "ALL.";
  }else{
      $sucu = "PET.";
  }
  $add ="Cambio Turno: ";
  $title = $add.'-'.$title.'-'.$fecha;

      $fecha_completa_inicio = $fecha .' 12:00:00';
      $fecha_completa_final  = $nuevafecha .' 12:00:00';

     $cadena_folio = mysqli_query($conexion,"SELECT MAX(folio) FROM agenda");
      $row_folio    = mysqli_fetch_array($cadena_folio);
      $folio        = $row_folio[0] + 1;

      $cadena_eventos = mysqli_query($conexion,"SELECT usuarios.id,usuarios.nombre_usuario
      FROM usuarios
      INNER JOIN personas ON personas.id = usuarios.id_persona
      WHERE
personas.id_sede = '1' 
AND usuarios.activo = '1' 
AND usuarios.id = '113'
OR usuarios.id = '2' 
OR usuarios.id = '161'");
//                          //  personas.id_sede = '$id_sede' AND usuarios.id_perfil = '2' OR  usuarios.id = '2'OR 
      while($row_e = mysqli_fetch_array($cadena_eventos)){
          $cadena_agenda = mysqli_query($conexion,"INSERT INTO agenda (folio,title,start,end,id_usuario,fecha,hora,backgroundColor,borderColor)
      VALUES ('$folio','$title','$fecha_completa_inicio','$fecha_completa_final','$row_e[0]','$fecha','$hora','$color','$color')");
      }
/////////////////////////////////////////notificaciones////////////////////////////////////////////////////////
     }
    else{
      echo "";
    }

  }elseif (!empty($id_registro)) {
    $cadena_actualizar = "UPDATE cambio_turnoSistemas SET empleado = '$nombre', departamento='$departamento',sucursal= '$sucursal2', turno_actual = '$horarioA', turno_nuevo='$horario', horario_inicio = '$datetimeIn', horario_final = '$datetimeFin',comentario = '$comentario', fechahora = '$fechahora', usuario = '$id_usuario' WHERE id = '$id_registro'";
    $consulta_actualizar = mysqli_query($conexion, $cadena_actualizar);
    echo "actualizado";
  }
  //////////////////////////////incidencias/////////////////////////////////////////////////////////
  
?>