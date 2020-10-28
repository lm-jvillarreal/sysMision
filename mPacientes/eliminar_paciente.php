<?php 
include '../global_settings/conexion.php';

$id_paciente = $_POST['id_paciente'];
  
   $eliminar = mysqli_query($conexion, "DELETE FROM pacientes WHERE id = '$id_paciente'");
   echo"ok";
  ?>