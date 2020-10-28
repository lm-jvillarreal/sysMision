<?php
include '../global_seguridad/verificar_sesion.php';

$cadenaPedido = "SELECT ID, 
                        NOMBRE_CLIENTE, 
                        TELEFONO_CLIENTE, 
                        DIRECCION_CLIENTE, 
                        TIPO_PEDIDO,
                        (SELECT nombre_usuario FROM usuarios WHERE id = pv_pedidos.ID_SURTEPEDIDO),
                        ESTATUS_PEDIDO,
                        ESTATUS_SURTIDO,
                        (SELECT CONCAT(NOMBRE,' ',AP_PATERNO,' ',AP_MATERNO) FROM pv_repartidores WHERE ID=pv_pedidos.ID_REPARTEPEDIDO),
                        ESTATUS_REPARTO,
                        MONTO_LIQUIDA
                  FROM pv_pedidos
                  WHERE (ESTATUS_PEDIDO='1' OR ESTATUS_PEDIDO='2' OR ESTATUS_PEDIDO='3')
                  AND FECHA_AGENDAPEDIDO='$fecha'";
$consultaPedido = mysqli_query($conexion,$cadenaPedido);

$cuerpo="";
while($rowPedido=mysqli_fetch_array($consultaPedido)){
  if($rowPedido[6]=='1' && is_null($rowPedido[7])){
   $estatus = "<center><span class='label label-danger'>En Espera</span></center>";
   $asignar_surtido = "<center><a href='#' data-folio = '$rowPedido[0]' data-toggle = 'modal' data-target = '#modal-personal' class='btn btn-success' target='blank'><i class='fa fa-pencil-square-o fa-lg' aria-hidden='true'></i></a></center>";
   $asignar_reparto = "";
   $liberar_pedido = "";
  }elseif($rowPedido[6]=='1' || $rowPedido[6]=='2' && $rowPedido[7]=='1'){
   $estatus="<center><span class='label label-warning'>Asignado</span></center>";
   $asignar_surtido = "";
   $asignar_reparto = "";
   $liberar_pedido = "";
  }elseif($rowPedido[6]=='2' && $rowPedido[7]=='2'){
   $estatus="<center><span class='label label-warning'>Surtiendo</span></center>";
   $asignar_surtido="";
   $asignar_reparto="";
   $liberar_pedido="";
  }elseif($rowPedido[6]=='2' && $rowPedido[7]=='3'){
   $estatus="<center><span class='label label-warning'>Surtido parcial</span></center>";
   $asignar_surtido="";
   $asignar_reparto = "";
   $liberar_pedido="";
  }elseif($rowPedido[6]=='2' && $rowPedido[7]=='4'){
   $estatus = "<center><span class='label label-warning'>Surtido</span></center>";
   $asignar_surtido="<center><a href='#' data-folio = '$rowPedido[0]' data-toggle = 'modal' data-target = '#modal-reparto' class='btn btn-success' target='blank'><i class='fa fa-taxi fa-lg' aria-hidden='true'></i></a></center>";
   $asignar_reparto = "";
   $liberar_pedido="";
}elseif($rowPedido[6]=='3' && $rowPedido[9]=='1'){
   $estatus="<center><span class='label label-warning'>Asignado</span></center>";
   $asignar_surtido="";
   $asignar_reparto="";
   $liberar_pedido = "<center><a href='#' onclick='liberar_entrega($rowPedido[0])' class='btn btn-success'><i class='fa fa-check fa-lg' aria-hidden='true'></i></a></center>";
  }elseif($rowPedido[6]=='3' && $rowPedido[9]=='2'){
   $estatus="<center><span class='label label-success'>Entregado</span></center>";
   $asignar_surtido="";
   $asignar_reparto="";
   $liberar_pedido="";
  }
  $renglon = "
		{
         \"folio\":\"$rowPedido[0]\",
         \"cliente\":\"$rowPedido[1]\",
         \"telefono\":\"$rowPedido[2]\",
         \"direccion\":\"$rowPedido[3]\",
         \"tipo_pedido\":\"$rowPedido[4]\",
         \"surtidor\":\"$rowPedido[5]\",
         \"repartidor\":\"$rowPedido[8]\",
         \"monto\":\"$rowPedido[10]\",
         \"estatus\":\"$estatus\",
         \"opciones\":\"$asignar_surtido $asignar_reparto $liberar_pedido\"
		},";
	$cuerpo = $cuerpo.$renglon;
}
$cuerpo2 = trim($cuerpo, ',');

$tabla = "
["
.$cuerpo2.
"]
";
echo $tabla;
?>