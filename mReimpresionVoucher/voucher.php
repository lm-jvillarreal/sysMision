<?php
include '../global_settings/conexion_oracle.php';
include '../global_seguridad/verificar_sesion.php';
$no_ticket = $_GET['tckt'];
$sucursal = $_GET['scrsl'];

$cadena_validar = "SELECT tnpc_merchant_id, tnpc_expiracion_tarjeta, TNPC_CODIGO_AUTORIZACION, TO_CHAR(TNPD_FECHA_HORA,'hh:mi:ss a.m.'),TO_CHAR(TNPD_FECHA_HORA,'dd/mm/yyyy') FROM PV_TRANSACCIONES_NETPAY WHERE  CONCAT(ticn_aaaammddventa,TICN_FOLIO) = '$no_ticket' AND CFGC_SUCURSAL = '$sucursal'";
$consulta_validar = oci_parse($conexion_central, $cadena_validar);
                   oci_execute($consulta_validar);
$row_validar = oci_fetch_row($consulta_validar);

$cadena_voucher = "SELECT fpac_te_numero_de_control, FPAC_REFERENCIA, fpac_te_estatus_transaccion, fpac_te_tipo_de_tarjeta, FPAC_TE_TIPO, FPAC_TE_BANCO_EMISOR, fpac_te_referencia, FPAN_MONTO, FPAC_TE_AID, FPAC_TE_TVR, FPAC_TE_TSI, FPAC_TE_APN, FPAN_TE_CASHBACK, ticc_sucursal, FPAC_NUMAUTORTC FROM PV_PAGOTICKET WHERE CONCAT(ticn_aaaammddventa,TICN_FOLIO) = '$no_ticket' AND ticc_sucursal = '$sucursal'";

$consulta_voucher = oci_parse($conexion_central, $cadena_voucher);
                   oci_execute($consulta_voucher);
$row_voucher = oci_fetch_row($consulta_voucher);

$existe = oci_num_rows($consulta_voucher);

if($existe==0){
  echo "El ticket ingresado no fue procesado por pago electrónico";
}else{

switch ($row_voucher[13]) {
  case '1':
    $sucursal = "DIAZ ORDAZ";
    break;
  case '2':
    $sucursal = "ARBOLEDAS";
  break;
  case '3':
    $sucursal = "VILLEGAS";
  break;
  case '4':
    $sucursal = "ALLENDE";
  break;
  default:
    $sucursal = "";
    break;
}

$cashback = $row_voucher[12];
if ($cashback=='0') {
  $monto_cashbk = "";
  $total = "";
}else{
  $monto_cashbk = "Cashback:".money_format("%.2n", $cashback);
  $total_sup = "Total:".money_format("%.2n", $cashback+$row_voucher[7]);
}

if ($row_voucher[2]=="A") {
  $status = "APROBADA";
}
?>
<!DOCTYPE html>
<html id="voucher" lang="es">

<head>
  <link rel="stylesheet" href="style.css">
  <script src="script.js"></script>

</head>

<body>
  <div class="ticket">
    <p class="centrado">Banorte
      <br>Venta
      <br>La Misión Supermercados, S.A. de C.V.
      <br>SUCURSAL <?php echo $sucursal; ?>
  	  <br>RFC: MSU940322LJ4
  	  <br>DIAZ ORDAZ 0-901 CENTRO 67700 LINARES 19 MEX
  	  <br>821 212 6200
  	  <br>***REIMPRESIÓN***
  	</p>
    <table>
      <tbody>
        <tr>
          <td>No. de afiliación:<?php echo $row_validar[0]; ?></td>
        </tr>
        <tr>
          <td>Terminal:<?php echo $row_validar[0]; ?></td>
        </tr>
        <tr>
          <td>Número control:<?php echo $row_voucher[0]; ?></td>
        </tr>
        <tr>
          <td>Tarjeta:<?php echo "xxxxxxxxxxxx".$row_voucher[1]; ?></td>
        </tr>
        <tr>
          <td>Fecha de expiración:<?php echo $row_validar[1]; ?></td>
        </tr>
        <tr>
          <td align="center"><?php echo $status; ?></td>
        </tr>
        <tr>
          <td>Tipo de tarjeta: <?php echo $row_voucher[3]; ?></td>
        </tr>
        <tr>
          <td>Tipo:<?php echo $row_voucher[4]; ?></td>
        </tr>
        <tr>
          <td>Banco emisor:<?php echo $row_voucher[5]; ?></td>
        </tr>
        <tr>
          <td>Autorización:<?php echo $row_voucher[14]; ?></td>
        </tr>
        <tr>
          <td>Referencia:<?php echo $row_voucher[6]; ?></td>
        </tr>
        <tr>
          <td><br></td>
        </tr>
        <tr>
          <td>Importe:<?php echo money_format("%.2n",$row_voucher[7]); ?></td>
        </tr>
        <tr>
          <td><?php echo $monto_cashbk; ?></td>
        </tr>
        <tr>
          <td><?php echo $total_sup; ?></td>
        </tr>
        <tr>
          <td align="right">--------------------------------<br>
            <center>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              Firma
            </center>
          </td>
        </tr>
        <tr>
          <td><br></td>
        </tr>
        <tr>
          <td>Fecha:<?php echo $row_validar[3]; ?></td>
        </tr>
         <tr>
          <td>Hora:<?php echo $row_validar[4]; ?></td>
        </tr>
         <tr>
          <td>AID:<?php echo $row_voucher[8]; ?></td>
        </tr>
         <tr>
          <td>TVR:<?php echo $row_voucher[9]; ?></td>
        </tr>
         <tr>
          <td>TSI:<?php echo $row_voucher[10]; ?></td>
        </tr>
         <tr>
          <td>APN:<?php echo $row_voucher[11]; ?></td>
        </tr>
        <tr>
          <td>Impreso por:<?php echo $nombre_persona; ?></td>
        </tr>
      </tbody>
    </table>
  </div>
  <button class="oculto-impresion" onclick="imprimir()">Imprimir</button>
  <script>
    function imprimir() {
    window.print();
}
  </script>
</body>

</html>
<?php
}
?>