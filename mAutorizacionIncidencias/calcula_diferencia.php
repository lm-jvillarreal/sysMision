<?php 

  include '../global_seguridad/verificar_sesion.php';
  date_default_timezone_set('America/Monterrey');

   $id_registro =$_POST['$id_registro'];
   $decision =$_POST['$decision'];
  //  $fecha_inicio = $_POST['fecha_inicio'];
  //  $fecha_fin   = $_POST['fecha_fin']; 
 

  //  $fecha_inicio = new DateTime($fecha_inicio); 
  //  $fecha_fin   = new DateTime($fecha_fin); 

  //  $diferencia  = $fecha_inicio->diff($fecha_fin);
$resultado = ($decision);
   echo $resultado;
   
?> 