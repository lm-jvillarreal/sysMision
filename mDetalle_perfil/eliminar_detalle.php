<?php
include '../global_seguridad/verificar_sesion.php';
$id_detalle = $_GET['id'];
$cadena_detalle = "SELECT id_perfil, id_modulo FROM detalle_perfil WHERE id = '$id_detalle'";
$consulta_detalle = mysqli_query($conexion, $cadena_detalle);
$row_detalle = mysqli_fetch_array($consulta_detalle);
$id_perfil = $row_detalle[0];
$id_modulo = $row_detalle[1];

$cadena_usuarios = "SELECT id FROM usuarios WHERE id_perfil = '$id_perfil'";
$consulta_usuarios = mysqli_query($conexion, $cadena_usuarios);
while($row_usuarios = mysqli_fetch_array($consulta_usuarios)){
    $cadena_elimina = "DELETE FROM detalle_usuario WHERE id_usuario = '$row_usuarios[0]' AND id_modulo = '$id_modulo'";
    $consulta_elimina = mysqli_query($conexion, $cadena_elimina);
}
$cadenaElimina_detalle = "DELETE FROM detalle_perfil WHERE id = '$id_detalle'";
$consultaElimina_detalle = mysqli_query($conexion, $cadenaElimina_detalle);

echo "<script>window.location='index.php';</script>";
?>