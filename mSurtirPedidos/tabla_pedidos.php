<?php
include '../global_seguridad/verificar_sesion.php';

$cadenaPedido = "SELECT ID, 
                        NOMBRE_CLIENTE, 
                        TELEFONO_CLIENTE, 
                        DIRECCION_CLIENTE, 
                        TIPO_PEDIDO,
                        (SELECT nombre_usuario FROM usuarios WHERE id = pv_pedidos.ID_SURTEPEDIDO),
                        ESTATUS_PEDIDO,
                        ESTATUS_SURTIDO
                  FROM pv_pedidos 
                  WHERE (ESTATUS_PEDIDO='1' OR ESTATUS_PEDIDO='2')
                  AND ID_SURTEPEDIDO = '$id_usuario'
                  AND FECHA_AGENDAPEDIDO='$fecha'";
$consultaPedido = mysqli_query($conexion,$cadenaPedido);

$cuerpo="";
while($rowPedido=mysqli_fetch_array($consultaPedido)){
  $link = "<center><a href='#' data-folio = '$rowPedido[0]' data-toggle = 'modal' data-target = '#modal-detalle' class='btn btn-success' target='blank'><i class='fa fa-check fa-lg' aria-hidden='true'></i></a></center>";
  if($rowPedido[6]=='1' && is_null($rowPedido[7])){
   $estatus="<center><span class='label label-danger'>En Espera</span></center>";
  }elseif($rowPedido[6]=='1' || $rowPedido[6]=='2' && $rowPedido[7]=='1'){
   $estatus="<center><span class='label label-warning'>Asignado</span></center>";
  }elseif($rowPedido[6]=='2' && $rowPedido[7]=='2'){
   $estatus="<center><span class='label label-warning'>Surtiendo</span></center>";
  }elseif($rowPedido[6]=='2' && $rowPedido[7]=='3'){
   $estatus="<center><span class='label label-success'>Surtido Parcial</span></center>";
  }elseif($rowPedido[6]=='2' && $rowPedido[7]=='4'){
     $estatus = "<center><span class='label label-warning'>Surtido</span></center>";
  }
  $renglon = "
		{
      \"folio\":\"$rowPedido[0]\",
      \"cliente\":\"$rowPedido[1]\",
      \"telefono\":\"$rowPedido[2]\",
      \"direccion\":\"$rowPedido[3]\",
      \"tipo_pedido\":\"$rowPedido[4]\",
      \"surtidor\":\"$rowPedido[5]\",
      \"estatus\":\"$estatus\",
      \"opciones\":\"$link\"
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