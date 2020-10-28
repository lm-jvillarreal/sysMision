<?php 
include '../global_settings/conexion.php';

$id_medico = $_POST['id_medico'];
  
   $qryEliminar = "DELETE FROM medicos WHERE id = '$id_medico'";

   $resEliminar = mysqli_query($conexion, $qryEliminar);
   
   echo"ok";
  ?>