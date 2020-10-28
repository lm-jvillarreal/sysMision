<?php
require_once('../plugins/spreadsheet-reader/php-excel-reader/excel_reader2.php');
require_once('../plugins/spreadsheet-reader/SpreadsheetReader.php');

include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d");
$hora=date ("h:i:s");

switch ($id_sede) {
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

if( isset($_POST["action"]) ){
 
 $error = false;
 
 $allowedFileType = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
 
 if(in_array($_FILES["file"]["type"],$allowedFileType)){

	$ruta = "../mControl_produccion/formatos/" . $_FILES['file']['name'];
	move_uploaded_file($_FILES['file']['tmp_name'], $ruta);

	$Reader = new SpreadsheetReader($ruta);

	$sheetCount = count($Reader->sheets());

	for($i=0;$i<$sheetCount;$i++){

		$Reader->ChangeSheet($i);
			
		$primera = true;
		foreach ($Reader as $Row)
		{
	                
	        // Evitamos la primer linea
			if($primera){
				$primera = false;
				continue;
			}

			// Obtenemos informacion
			$no_afiliacion= "";
			$fecha_transaccion=$Row[1];
			$hora_transaccion=$Row[2];
			$no_control= mysqli_real_escape_string($conexion,$Row[3]);
			$cod_autorizacion=$Row[4];
			$no_tarjeta=$Row[5];
			$monto =$Row[8];
			$referencia=$Row[9];
			$cod_resultado=$Row[23];
			$banco_emisor=$Row[25];
			$marca_tarjeta=$Row[26];
			$tipo_tarjeta=$Row[27];
			$cashback = $Row[17];
			if ($cashback=='') {
			  $monto_cashbk = "";
			  $total_sup = "";
			}else{
			  $monto_cashbk = "Cashback:".money_format("%.2n", $cashback);
			  $total_sup = "Total:".money_format("%.2n", $cashback+$monto);
			}

			if(isset($Row[0])) {
				$no_afiliacion= mysqli_real_escape_string($conexion,$Row[0]);
			}
			
		}
	}
  }
?>
				<!DOCTYPE html>
				<html id="voucher" lang="es">

				<head>
				  <link rel="stylesheet" href="style.css">
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
				          <td>No. de afiliación:<?php echo $no_afiliacion; ?></td>
				        </tr>
				        <tr>
				          <td>Terminal:<?php echo $no_afiliacion; ?></td>
				        </tr>
				        <tr>
				          <td>Número control:<?php echo $no_control; ?></td>
				        </tr>
				        <tr>
				          <td>Tarjeta:<?php echo $no_tarjeta; ?></td>
				        </tr>
				        <tr>
				          <td>Fecha de expiración:</td>
				        </tr>
				        <tr>
				          <td align="center"><?php echo $cod_resultado; ?></td>
				        </tr>
				        <tr>
				          <td align="center"></td>
				        </tr>
				        <tr>
				          <td>Tipo de tarjeta: <?php echo $marca_tarjeta; ?></td>
				        </tr>
				        <tr>
				          <td>Tipo:<?php echo $tipo_tarjeta; ?></td>
				        </tr>
				        <tr>
				          <td>Banco emisor:<?php echo $banco_emisor; ?></td>
				        </tr>
				        <tr>
				          <td>Autorización:<?php echo $cod_autorizacion; ?></td>
				        </tr>
				        <tr>
				          <td>Referencia:<?php echo $referencia; ?></td>
				        </tr>
				        <tr>
				          <td><br></td>
				        </tr>
				        <tr>
				          <td>Importe:<?php echo money_format("%.2n",$monto); ?></td>
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
				          <td>Fecha:<?php echo $fecha_transaccion; ?></td>
				        </tr>
				         <tr>
				          <td>Hora:<?php echo $hora_transaccion; ?></td>
				        </tr>
				         <tr>
				          <td>AID:</td>
				        </tr>
				         <tr>
				          <td>TVR:</td>
				        </tr>
				         <tr>
				          <td>TSI:</td>
				        </tr>
				         <tr>
				          <td>APN:</td>
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
<?php
 }else{
 	echo "invalido";
 }
?>