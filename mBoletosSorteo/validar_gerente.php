<?php
include '../global_seguridad/verificar_sesion.php';
$password=$_POST['password'];
$pass=md5($password);

$cadenaValidar="SELECT
                  u.id,
                  u.nombre_usuario 
                FROM
                  usuarios AS u
                  INNER JOIN personas AS p ON u.id_persona = p.id 
                WHERE
                  u.id_perfil = '2' 
                  AND p.id_sede = '$id_sede'
                  AND u.pass='$pass'";

$consultaValidar=mysqli_query($conexion,$cadenaValidar);
$rowValidar=mysqli_fetch_array($consultaValidar);
if($rowValidar>0){
  echo "valido";
}else{
  echo "no";
}
?>