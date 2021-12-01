<?php
include '../global_settings/conexion.php';

$p_user = $_POST['usuario'];
$p_contra = md5($_POST['pass']);

$cadenaValidar = "SELECT  
                    usuarios.id, 
                    usuarios.nombre_usuario, 
                    usuarios.id_persona, 
                    usuarios.id_perfil, 
                    CONCAT(personas.nombre,' ',personas.ap_paterno) AS 'Nombre Persona', 
                    personas.id_sede, 
                    usuarios.fecha, 
                    personas.e_mail,
                    personas.telefono
                  FROM usuarios 
                    INNER JOIN personas ON usuarios.id_persona = personas.id
                    AND (usuarios.nombre_usuario='$p_user' or personas.num_empleado = '$p_user' AND personas.num_empleado is not null)
                    AND usuarios.pass='$p_contra'
                    AND usuarios.activo='1' 
                    AND personas.activo='1'";

                    echo "$cadenaValidar";

$consultaValidar = mysqli_query($conexion,$cadenaValidar);
$rowUsuario = mysqli_fetch_array($consultaValidar);
$datos=array();
$conteo=count($rowUsuario[0]);
if($conteo==0){
  array_push($datos,array(
    'autenticado'=>'NO',
    'id'=>'',
    'nombreUsuario'=>$p_user,
    'nombrePersona'=>$p_contra,
    'idSede'=>'',
    'eMail'=>''
  ));
}else{
  array_push($datos,array(
    'autenticado'=>'SI',
    'id'=>$rowUsuario[0],
    'nombreUsuario'=>$rowUsuario[1],
    'nombrePersona'=>$rowUsuario[4],
    'idSede'=>$rowUsuario[5],
    'eMail'=>$rowUsuario[7]
  ));
}
echo utf8_encode(json_encode($datos));
?>