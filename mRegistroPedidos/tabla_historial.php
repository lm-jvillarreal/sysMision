<?php
include '../global_seguridad/verificar_sesion.php';

$fecha_inicial = $_POST['fecha_inicial'];
$fecha_final = $_POST['fecha_final'];

$datos=array();
$cadenaPedido = "SELECT ID, 
                        NOMBRE_CLIENTE, 
                        TELEFONO_CLIENTE, 
                        CONCAT(CALLE_CLIENTE,' ',NUMERO_CLIENTE,' ',COLONIA_CLIENTE), 
                        TIPO_PEDIDO,
                        (SELECT nombre_usuario FROM usuarios WHERE id = pv_pedidos.ID_SURTEPEDIDO),
                        ESTATUS_PEDIDO,
                        ESTATUS_SURTIDO
                  FROM pv_pedidos 
                  WHERE (ESTATUS_PEDIDO='1' OR ESTATUS_PEDIDO='2')
                  AND (FECHA_AGENDAPEDIDO >= '$fecha_inicial' AND FECHA_AGENDAPEDIDO <= '$fecha_final')";
$consultaPedido = mysqli_query($conexion,$cadenaPedido);

while($rowPedido=mysqli_fetch_array($consultaPedido)){
  $pedido_pdf="<center><a href='#' class='btn btn-default btn-sm' onclick='ver_pdf($rowPedido[0])'><i class='fa fa-file-pdf-o fa-lg' aria-hidden='true'></i></a>";
  $detalle = "&nbsp;<a href='#' data-folio = '$rowPedido[0]' data-toggle = 'modal' data-target = '#modal-historial' class='btn btn-primary btn-sm' target='blank'><i class='fa fa-search fa-lg' aria-hidden='true'></i></a>";
  $liberar = "&nbsp;<a href='#' data-folio = '$rowPedido[0]' data-toggle = 'modal' data-target = '#modal-ticket' class='btn btn-warning btn-sm'><i class='fa fa-truck fa-lg' aria-hidden='true'></i></a>";
  $entregado="&nbsp;<a href='ticket_pdf.php?flp=$rowPedido[0]' class='btn btn-success btn-sm' target='blank'><i class='fa fa-print fa-lg'></i></a></center>";
  $link=$pedido_pdf.$detalle.$liberar.$entregado;
  if($rowPedido[6]=='1'){
   $estatus="<center><span class='label label-danger'>En Espera</span></center>";
  }elseif($rowPedido[6]=='2' && $rowPedido[7]=='1'){
   $estatus="<center><span class='label label-warning'>Asignado</span></center>";
  }elseif($rowPedido[6]=='2' && $rowPedido[7]=='2'){
   $estatus="<center><span class='label label-warning'>Surtiendo</span></center>";
  }elseif($rowPedido[6]=='2' && $rowPedido[7]=='3'){
   $estatus="<center><span class='label label-success'>Surtido parcial</span></center>";
  }elseif($rowPedido[6]=='2' && $rowPedido[7]=='4'){
    $estatus="<center><span class='label label-success'>Surtido</span></center>";
  }
  array_push($datos,array(
    'folio'=>$rowPedido[0],
    'cliente'=>$rowPedido[1],
    'telefono'=>$rowPedido[2],
    'direccion'=>$rowPedido[3],
    'tipo_pedido'=>$rowPedido[4],
    'estatus'=>$estatus,
    'opciones'=>$link
  ));
}
echo utf8_encode(json_encode($datos));
?>