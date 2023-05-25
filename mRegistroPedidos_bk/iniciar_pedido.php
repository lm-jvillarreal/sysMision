<?php
include '../global_seguridad/verificar_sesion.php';
$fechahora=$fecha.' '.$hora;
$nombre = $_POST['nombre'];
$telefono = $_POST['telefono'];
$colonia = $_POST['colonia'];
$calle = $_POST['calle'];
$numero = $_POST['numero_casa'];
$tipo_pedido = $_POST['tipo_pedido'];
$fecha_entrega = $_POST['fecha_entrega'];
$domicilio = $calle.' '.$numero.', '.$colonia;

$cadenaInsertar = "INSERT INTO pv_pedidos(TIPO_PEDIDO, NOMBRE_CLIENTE, TELEFONO_CLIENTE, DIRECCION_CLIENTE, ID_TOMAPEDIDO, FECHA_PEDIDO, HORA_INICIAPEDIDO, FECHA_AGENDAPEDIDO, ESTATUS_PEDIDO, SUCURSAL)VALUES('$tipo_pedido', '$nombre', '$telefono', '$domicilio', '$id_usuario', '$fecha', '$fechahora', '$fecha_entrega', '0', '$id_sede')";
$InsertaPedido = mysqli_query($conexion,$cadenaInsertar);

$cadenaFolio = "SELECT MAX(ID) FROM pv_pedidos";
$consultaFolio = mysqli_query($conexion,$cadenaFolio);
$rowFolio = mysqli_fetch_array($consultaFolio);
$folio = $rowFolio[0];

echo $folio;
?>