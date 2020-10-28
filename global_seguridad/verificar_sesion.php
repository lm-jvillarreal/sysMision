<?php
session_name("sysAdMision");
session_start();

date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("H:i:s");
$seg_sesion=120 * 60;
//antes de hacer los cálculos, compruebo que el usuario está logueado 
//utilizamos el mismo script que antes 
if (!isset($_SESSION["sysAdMision_autenticado"]) || $_SESSION["sysAdMision_autenticado"] != "SI")
{ 
    //si no está logueado lo envío a la página de autentificación 
    echo"<script language=\"javascript\">window.location=\"../mLogin/index.php\"</script>";
} 
else 
{
  //Validacion de tiempo///
  $fechaGuardada = $_SESSION["sysAdMision_ultimoAcceso"];
  $ahora = date("Y-n-j H:i:s"); 
  $tiempo_transcurrido = (strtotime($ahora)-strtotime($fechaGuardada)); 
  //echo strtotime($ahora).'<br>'.strtotime($fechaGuardada).'<br>'.$tiempo_transcurrido.'<br>'.$seg_sesion;
  if($tiempo_transcurrido >= $seg_sesion)//30 segundos 
	{ 
		session_destroy(); // destruyo la sesión 
		echo"<script language=\"javascript\">window.location=\"../mLogin/index.php\"</script>";
  }
	else //sino, actualizo la fecha y hora de la sesión 
	{
    $_SESSION["sysAdMision_ultimoAcceso"] = $ahora; 
    //se manda llamar la conexion
    include "datos_usuario_acceso.php";

    if ($acceso_modulo != 1) {
        echo"<script language=\"javascript\">window.location=\"../mPanel_control/index.php\"</script>";
    }else{

      $cadena_solo_sucursal = "SELECT solo_sucursal, registros_propios, solo_lectura FROM detalle_usuario WHERE id_usuario = '$id_usuario' AND id_modulo = '$id_modulo'";
      //echo "$cadena_solo_sucursal";
      $consulta_solo_sucursal = mysqli_query($conexion, $cadena_solo_sucursal);
      $row_sucursal = mysqli_fetch_array($consulta_solo_sucursal);
      $solo_sucursal = $row_sucursal[0];
      $registros_propios = $row_sucursal[1];
      $valor_soloLectura = $row_sucursal[2];
      if ($valor_soloLectura=='1') {
        $solo_lectura = "style='display: none'";
      }else{
        $solo_lectura = '';
      }

      $cadena_am = "INSERT INTO acceso_modulos (id_modulo, id_usuario, fecha, hora, activo, usuario)VALUES('$id_modulo', '$id_usuario', '$fecha', '$hora', '1', '$id_usuario')";
      $consulta_am = mysqli_query($conexion, $cadena_am); 
      //libro de operaciones para tornos del area de estatores
    }
  }
} 
