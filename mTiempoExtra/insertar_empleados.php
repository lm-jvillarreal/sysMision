<?php
  include '../global_seguridad/verificar_sesion.php';
  include '../global_settings/consulta_sqlsrvr.php'; //consultar la firma
  date_default_timezone_set('America/Monterrey');

  $fecha=date("Y-m-d"); 
  $hora=date ("H:i:s");

  $id_registro  = $_POST['id_registro'];
  $nombre       = $_POST['id_persona'];
  // $departamento = $_POST['departamento'];
  // $sucursal     = $_POST['sucursal'];
  $hora_inicio  = $_POST['fecha_inicio'];
  $hora_final   = $_POST['fecha_fin'];
  $firma        = $_POST['firma'];
  
  $fecha_inicio = substr($hora_inicio, 0, 10);
  $fecha_final  = substr($hora_final,  0, 10);
  $hora_inicio  = substr($hora_inicio, 11,5);
  $hora_final   = substr($hora_final,  11,5);

  $cadena_persona = "SELECT codigo,(rfcnum + cast(codigo as varchar) ) AS 'firma' FROM empleados WHERE activo = 'S' AND codigo = '$nombre'"; 
  $clave= $row_persona['firma'];

  if(empty($id_registro)){
    if($firma=$clave){
    $cadena_insertar = "INSERT INTO tiempo_extra (nombre,
            departamento,
            sucursal,
            hora_inicio,
            hora_final,
            tiempo,
            comentario,
            fecha,
            hora,
            activo,
            usuario,
            folio,
            fecha_inicio,
            fecha_final,
            motivo,
            motivoOtro)
            VALUES('$nombre',null,null,'$hora_inicio','$hora_final', null,null,'$fecha','$hora', '1', '$id_usuario', '1','$fecha_inicio','$fecha_final',null,null)";
    // $insertar_registro = mysqli_query($conexion,$cadena_insertar);
    echo "$clave";
  }
}
  
else if(!empty($id_registro)){
  $cadena_actualizar = "UPDATE tiempo_extra 
  SET nombre   = '$nombre',
  departamento = '$departamento',        
  sucursal     = '$sucursal',
  fecha_inicio = '$fecha_inicio',
  fecha_final  = '$fecha_final',
  tiempo       = '$tiempo',
  fecha        = '$fecha',
  hora         = '$hora',
  activo       = '1',
  usuario      = '$id_usuario',
  firma        = '$firma'
  WHERE
    id = '$id_registro'";
  $consulta_actualizar = mysqli_query($conexion, $cadena_actualizar);
  echo "ok_actualizado";
  }
?>