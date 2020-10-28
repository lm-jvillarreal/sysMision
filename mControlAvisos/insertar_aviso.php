<?php
include '../global_seguridad/verificar_sesion.php';
$titulo_aviso=$_POST['titulo_aviso'];
$fecha_vigencia=$_POST['fecha_vigencia'];
$cantidad_vigencia=$_POST['cantidad_apariciones'];
$perfil=$_POST['perfil'];
$detalle_aviso=$_POST['detalle_aviso'];
$fechahora=$fecha.' '.$hora;

$cadenaPerfil="SELECT id from usuarios where id_perfil='$perfil'";
$consultaPerfil=mysqli_query($conexion,$cadenaPerfil);
while($rowPerfil=mysqli_fetch_array($consultaPerfil)){
  $cadena_insertar="INSERT INTO global_avisos (TITULO_AVISO, DETALLE_AVISO, ID_PERFIL, USUARIO_VISUALIZA, FECHAHORA_VIGENCIA, CANTIDAD_APARICIONES, FECHAHORA, ACTIVO, USUARIO_REGISTRA)VALUES('$titulo_aviso','$detalle_aviso','$perfil','$rowPerfil[0]','$fecha_vigencia','$cantidad_vigencia','$fechahora','1','$id_usuario')";
  $insertarAviso=mysqli_query($conexion,$cadena_insertar);
}
echo "ok";
?>