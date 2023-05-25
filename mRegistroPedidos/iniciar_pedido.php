<?php
include '../global_seguridad/verificar_sesion.php';
$fechahora=$fecha.' '.$hora;
$nombre = $_POST['nombre'];
$telefono = $_POST['telefono'];
$colonia = $_POST['colonia'];
$calle = $_POST['calle'];
$numero = $_POST['numero_casa'];
$entrecalles=$_POST['entre_calles'];
$referencia=$_POST['referencia'];
$tipo_pedido = $_POST['metodo_pago'];
$fecha_entrega = $_POST['fecha_entrega'];

$cadenaInsertar = "INSERT INTO pv_pedidos(TIPO_PEDIDO, NOMBRE_CLIENTE, TELEFONO_CLIENTE, COLONIA_CLIENTE, CALLE_CLIENTE, NUMERO_CLIENTE, ENTRECALLES_CLIENTE, REFERENCIA_DOMICILIO, ID_TOMAPEDIDO, FECHA_PEDIDO, HORA_INICIAPEDIDO, FECHA_AGENDAPEDIDO, ESTATUS_PEDIDO, SUCURSAL)VALUES('$tipo_pedido', '$nombre', '$telefono', '$colonia', '$calle', '$numero', '$entrecalles', '$referencia', '$id_usuario', '$fecha', '$fechahora', '$fecha_entrega', '0', '$id_sede')";
$InsertaPedido = mysqli_query($conexion,$cadenaInsertar);

$cadenaFolio = "SELECT MAX(ID) FROM pv_pedidos";
$consultaFolio = mysqli_query($conexion,$cadenaFolio);
$rowFolio = mysqli_fetch_array($consultaFolio);
$folio = $rowFolio[0];

echo $folio;
?>