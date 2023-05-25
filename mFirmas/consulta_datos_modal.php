<?php
  include '../global_seguridad/verificar_sesion.php';
  include '../global_settings/conexion.php';
  include '../global_settings/consulta_sqlsrvr.php';
  
    $id = $_POST['id'];
  
    $cadena = "SELECT id, nombre FROM firmas_autorizadas WHERE id ='$id'";
    $consulta = mysqli_query($conexion, $cadena);
    $row      = mysqli_fetch_array($consulta);
  
    $cadena_persona = "SELECT nombre, ap_paterno, ap_materno FROM empleados WHERE codigo = '$row[1]'";
    $consulta_persona = sqlsrv_query($conn, $cadena_persona);
    $row_persona = sqlsrv_fetch_array( $consulta_persona, SQLSRV_FETCH_ASSOC);
    $nombre_empleado = $row_persona['nombre'].' '.$row_persona['ap_paterno'].' '.$row_persona['ap_materno'];
    $nombre_empleado=ucwords(strtolower($nombre_empleado));
    $empleado = $row[1].' - '.$nombre_empleado; 
  
  $array2 = array(
      $empleado, //Nombre
      //$row[0] //id_persona
    );
  
    $array = json_encode($array2);
    echo "$array";
  ?>
