<?php
include '../global_seguridad/verificar_sesion.php';

date_default_timezone_set("America/Monterrey");
$fecha = date("Y-m-d");
$hora = date("H:i:s");

$articulo = $_POST['articulo'];
$descripcion = $_POST['descripcion'];
$existencia = (empty($_POST['existencia'])) ? 'NULL' : $_POST['existencia'];
$ultima_entrada = $_POST['ultima_compra'];
$tipo_mov = $_POST['tipo_mov'];
$folio_mov = $_POST['folio_mov'];
//$cantidad_mov = $_POST['cantidad_surtida'];
$cantidad_mov = (empty($_POST['cantidad_surtida'])) ? 'NULL' : $_POST['cantidad_surtida'];
$proveedor = $_POST['proveedor'];
$departamento = $_POST['departamento'];
$familia = $_POST['familia'];
$ultimo_costo = (empty($_POST['ult_costo'])) ? 'NULL' : $_POST['ult_costo'];
$unidad_empaque = $_POST['u_emp'];
$ventas = (empty($_POST['ventas'])) ? 'NULL' : $_POST['ventas'];
$teorico = (empty($_POST['teorico'])) ? 'NULL' : $_POST['teorico'];
$faltante = (empty($_POST['faltante'])) ? 'NULL' : $_POST['faltante'];
$faltante_cajas = (empty($_POST['faltante_cajas'])) ? 'NULL' : $_POST['faltante_cajas'];
$dias_inv = $_POST['dias_inv'];
$meses_inv = $_POST['meses_inv'];
$comentario = $_POST['comentario'];
$cadenaValidar = "SELECT * FROM auditoria_pv WHERE articulo = '$articulo' AND usuario = '$id_usuario' AND activo = '1'";
$validarExiste = mysqli_query($conexion,$cadenaValidar);
$rowValidar = mysqli_fetch_array($validarExiste);

$conteoExiste = COUNT($rowValidar);
if($conteoExiste>0){
  echo "existe";
}else{
  $cadenaInsertar = "INSERT INTO auditoria_pv (articulo, descripcion, existencia, ultima_entrada, tipo_mov, folio_mov, cantidad_mov, proveedor, departamento, familia, ultimo_costo, unidad_empaque, ventas, teorico, faltante, faltante_cajas, dias_inv, meses_inv, fecha, hora, activo, usuario, sucursal, codigo_comentario) VALUES (
    '$articulo', '$descripcion', $existencia, '$ultima_entrada', '$tipo_mov', '$folio_mov', $cantidad_mov, '$proveedor', '$departamento', '$familia', $ultimo_costo, '$unidad_empaque', $ventas, $teorico, $faltante, $faltante_cajas, '$dias_inv', '$meses_inv', '$fecha', '$hora', '1', '$id_usuario', '$id_sede', '$comentario')";
  
  $consultaInsertar = mysqli_query($conexion, $cadenaInsertar);
  echo "ok";
}
?>