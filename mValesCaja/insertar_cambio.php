<?php
include '../global_seguridad/verificar_sesion.php';
$ticket=$_POST['folio'];
$sucursal=$_POST['m_sucursal'];
$total=$_POST['m_total'];
$cajero=$_POST['m_cajero'];
$artc_articulo=$_POST['m_codigo'];
$artc_descripcion=$_POST['m_artc_descripcion'];
$cantidad=$_POST['m_cantidad'];
$precio=$_POST['m_precio'];
$precio_cambio=$_POST['m_cambio'];
$nombre_cliente=$_POST['m_nombre_cliente'];
$id_autoriza=$_POST['m_autoriza'];
$comentario=$_POST['comentario'];
$artc_familia=$_POST['m_familia'];
$id_cajero=$_POST['m_idCajero'];

$diferencia=$precio-$precio_cambio;
$total_diferencia=$diferencia*$cantidad;
$cadenaInsertar="INSERT INTO valecaja_provisional (FOLIO_TICKET, 
                                                   SUCURSAL, 
                                                   TOTAL_TICKET, 
                                                   CAJERO_TICKET, 
                                                   ARTC_ARTICULO, 
                                                   ARTC_DESCRIPCION, 
                                                   ARTC_CANTIDAD, 
                                                   ARTC_PRECIO, 
                                                   ARTC_CAMBIOPRECIO, 
                                                   ARTC_DIFERENCIAPRECIO, 
                                                   TOTAL_DIFERENCIAPRECIO, 
                                                   ID_AUTORIZA, 
                                                   NOMBRE_CLIENTE, 
                                                   FECHAHORA_CAMBIO,
                                                   COMENTARIO,
                                                   ESTATUS,
                                                   ACTIVO, 
                                                   USUARIO,
                                                   ARTC_FAMILIA,
                                                   CLAVECAJERO_TICKET)VALUES(
                                                     '$ticket',
                                                     '$sucursal',
                                                     '$total',
                                                     '$cajero',
                                                     '$artc_articulo',
                                                     '$artc_descripcion',
                                                     '$cantidad',
                                                     '$precio',
                                                     '$precio_cambio',
                                                     '$diferencia',
                                                     '$total_diferencia',
                                                     '$id_autoriza',
                                                     '$nombre_cliente',
                                                     '$fecha $hora',
                                                     '$comentario',
                                                     '1',
                                                     '1',
                                                     '$id_usuario',
                                                     '$artc_familia',
                                                     '$id_cajero'
                                                   )";
$insertarCambio=mysqli_query($conexion,$cadenaInsertar);

//echo $cadenaInsertar;
$cadenaFolio="SELECT MAX(ID) FROM valecaja_provisional WHERE SUCURSAL='$sucursal'";
$consultaFolio=mysqli_query($conexion,$cadenaFolio);
$rowFolio=mysqli_fetch_array($consultaFolio);
$id=$rowFolio[0];
echo $id;
?>