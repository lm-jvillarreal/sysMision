<?
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("h:i:s");
$folio=$_POST["folio"]; 

$cadena = mysqli_query($conexion,"SELECT codigo,pedido FROM  historial_pedido_materiales  WHERE folio = '$folio' AND pedido != '0'");
$resultado = 0;

while ($row = mysqli_fetch_array($cadena)) {
	$cadena_existencia = mysqli_query($conexion,"SELECT existencia FROM historial_existencia_materiales WHERE codigo = '$row[0]'");
	$row2 = mysqli_fetch_array($cadena_existencia);
	$resultado = $row2[0] - $row[1];

	$actu = mysqli_query($conexion,"UPDATE historial_existencia_materiales SET existencia = '$resultado' WHERE codigo = '$row[0]'");
}

$cadena1 = mysqli_query($conexion,"UPDATE materiales SET id_usuario_libero = '$id_usuario', activo = '2' WHERE folio = '$folio'");
echo "ok";
?>