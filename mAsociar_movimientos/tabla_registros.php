<?php
  include '../global_seguridad/verificar_sesion.php';
  include '../global_settings/conexion.php';
  include '../global_settings/consulta_sqlsrvr.php';

date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("h:i:s");

$fecIni = $_POST["fecha_inicial"];
$fecFin = str_replace("-","",$_POST["fecha_final"]);
$parametro = $_POST['parametro'];
$fecha      = date('Y-m-d');
$prim_dia   = date('Y-m-01');



if($parametro==0){
  $fechaInicioLW = $prim_dia;
  $fechaFinLW = $fecha;
}else{
  $fechaInicioLW = $fecIni;
  $fechaFinLW = $fecFin;
}


$solo_suc = ($solo_sucursal == '1') ? " AND incidencias.sucursal2='$id_sede'" : "";
$idUsr = $_POST['idUsr'];
$ide=$_GET['ide'];
$departamento = "";
$nombre_empleado="";
$sucursal="";
$datos = array();

  $cadena  = "SELECT b.id, b.movimiento, b.id_movimiento, b.comentario, b.imprime, s.nombre, b.error, em.nombre, fm.fecha
              FROM bitacora_errores_movimientos b 
              INNER JOIN sucursales s ON s.id = b.sucursal 
              INNER JOIN errores_movimientos em ON em.id = b.error
              INNER JOIN formatos_movimientos fm ON fm.id = b.id_movimiento";
  $consulta = mysqli_query($conexion, $cadena);
  $cuerpo         = "";

  while ($row_error = mysqli_fetch_array($consulta)) 
  {
    $cadena_libera = "SELECT CONCAT(p.nombre,' ',p.ap_paterno,' ',p.ap_materno)FROM personas as p INNER JOIN usuarios as u ON p.id=u.id_persona AND u.id = '$row_error[4]'";
    $usuario_libera = mysqli_query($conexion, $cadena_libera);
    $row_libera = mysqli_fetch_array($usuario_libera);
    $nombre_libera = $row_libera[0];

    $escape_comentario = mysqli_real_escape_string($conexion,$row_error[3]);
    if($row_error[1]=='ECHORI'){
      $nom_movimiento='CONVERSION CHORIZO';
    }elseif($row_error[1]=='EXCONV'){
        $nom_movimiento='CONVERSION ARTICULOS';
    }elseif($row_error[1]=='EXVIGI'){
        $nom_movimiento='ENTRADA POR VIGILANCIA';
    }elseif($row_error[1]=='SXMBOD'){
        $nom_movimiento = 'MERMA BODEGA';
    }elseif($row_error[1]=='SXMCAR'){
        $nom_movimiento='MERMA CARNICERIA';
    }elseif($row_error[1]=='SXMFCI'){
        $nom_movimiento='MERMA FARMACIA';
    }elseif($row_error[1]=='SXMFTA'){
        $nom_movimiento='MERMA FRUTAS Y VERDURAS';
    }elseif($row_error[1]=='SXMEDO'){
        $nom_movimiento='MERMA MAL ESTADO';
    }elseif($row_error[1]=='SXMPAN'){
        $nom_movimiento='MERMA PANADERÍA';
    }elseif($row_error[1]=='SXMTOR'){
        $nom_movimiento='MERMA TORTILLERÍA';
    }elseif($row_error[1]=='SXMVAR'){
        $nom_movimiento='MERMA VARIEDADES';
    }elseif($row_error[1]=='SFAACC'){
        $nom_movimiento='FARMACIA ACCIDENTES';
    }elseif($row_error[1]=='SFCBOT'){
        $nom_movimiento='FARMACIA BOTIQUÍN';
    }elseif($row_error[1]=='SXROB'){
        $nom_movimiento='SALIDA POR ROBO';
    }elseif($row_error[1]=='TRADEP'){
        $nom_movimiento='TRANSFERENCIA DEPTOS.';
    }elseif($row_error[1]=='SXMCAD'){
        $nom_movimiento='MERMA CADUCIDAD';
    }
    $movimiento = $row_error[1]."&nbsp; - &nbsp;".$nom_movimiento;
    array_push($datos, array(
      'id'=>$row_error[0],
      'movimiento'=>$movimiento,
      'sucursal'=>$row_error[5],
      'fecha' =>$row_error[8],
      'procesa'=>$nombre_libera,
      'error'=>$row_error[7],
      'comentario'=>$escape_comentario
    ));
    $departamento="";
    $nombre_empleado="";
  }
  echo utf8_encode(json_encode($datos));
 ?>