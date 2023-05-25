<?php
  include '../global_seguridad/verificar_sesion.php';
  include '../global_settings/consulta_sqlsrvr.php'; //consultar la firma
  date_default_timezone_set('America/Monterrey');

  $fecha=date("Y-m-d"); 
  $hora=date ("H:i:s");

  $id_registro  = $_POST['id_registro'];
  $nombre       = $_POST['id_persona'];
  $firma        = $_POST['firma'];

  //echo $nombre;
  //variable $firma = resultado del array de consultas
  //validar firma con clave para actualizar
  //SELECT codigo, (cast(codigo as varchar) + ' - ' + nombre + ' ' + ap_paterno + ' ' + ap_materno + ' '+ afiliacion + ' ' + rfcalfa + rfcnum + rfchomo) AS 'nombre' FROM empleados WHERE activo = 'S'"
  
  $cadena_persona = "SELECT codigo,(rfcnum + cast(codigo as varchar) ) AS 'firma' FROM empleados WHERE activo = 'S' AND codigo = '$nombre'"; 
  $clave= $row_persona['firma'];

  $cadena_persona = "SELECT codigo,(afiliacion + cast(codigo as varchar) ) AS 'firma' FROM empleados WHERE activo = 'S' AND codigo = '$nombre'"; 
  $consulta_persona = sqlsrv_query($conn, $cadena_persona);
  $row_persona = sqlsrv_fetch_array( $consulta_persona, SQLSRV_FETCH_ASSOC);
  $clave= $row_persona['firma'];

  $cadena_firma2 = "SELECT codigo,(rfcnum  + cast(codigo as varchar) )  AS 'firma2' FROM empleados WHERE activo = 'S' AND codigo = '$nombre'"; 
  $consulta_persona2 = sqlsrv_query($conn, $cadena_firma2);
  $row_persona1 = sqlsrv_fetch_array( $consulta_persona2, SQLSRV_FETCH_ASSOC);
  $clave2= $row_persona1['firma2'];

  $cadena_firma3 = "SELECT codigo,(rfcalfa  + cast(codigo as varchar) )  AS 'firma3' FROM empleados WHERE activo = 'S' AND codigo = '$nombre'"; 
  $consulta_persona3 = sqlsrv_query($conn, $cadena_firma3);
  $row_persona3 = sqlsrv_fetch_array( $consulta_persona3, SQLSRV_FETCH_ASSOC);
  $clave3= $row_persona3['firma3'];

  $cadena_firma4 = "SELECT codigo,(rfchomo  + cast(codigo as varchar) )  AS 'firma4' FROM empleados WHERE activo = 'S' AND codigo = '$nombre'"; 
  $consulta_persona4 = sqlsrv_query($conn, $cadena_firma4);
  $row_persona4 = sqlsrv_fetch_array( $consulta_persona4, SQLSRV_FETCH_ASSOC);
  $clave4= $row_persona4['firma4'];
 

// $data =array();
// $data[]=array("$clave", "$clave2","$clave3","$clave4");

// echo json_encode($data[array_rand($data)]);

// $d=mt_rand(1,30);
//    echo $d ;
//    if ($d == '1') {
//      echo "ingrese "
//    } else {
//      # code...
//    }
   
//echo json_encode($randomElement[0]);
//echo json_encode($data);
//$random=array_rand($data,-1);
//$resRandom=[$random];
//echo $resRandom;
 //$datas[rand(0, count($data) - 1)];
 //echo $datas;

  if(empty($id_registro)){
    if($firma=$clave){
    $cadena_actualizados = "UPDATE incidencias SET autorizacion = '2' WHERE id = '$id_registro'";
     //$insertar_registro = mysqli_query($conexion,$cadena_insertar);
    echo "ok";
  }
}
  
//else if(!empty($id_registro)){
  //$cadena_actualizar = "UPDATE incidencias SET autorizacion = '2' WHERE id = '$id_registro'";
  //$consulta_actualizar = mysqli_query($conexion, $cadena_actualizar);
  //echo "$cadena_actualizados";
  //}
?>