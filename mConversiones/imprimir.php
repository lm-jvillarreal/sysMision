<?php
  include '../global_seguridad/verificar_sesion.php';
  include '../global_settings/conexion.php';
  include '../global_settings/consulta_sqlsrvr.php';

  $ide =  $_GET['id_registro'];

  $cadena_consulta = "SELECT
  id, turno, sucursal, subreceta, produccion_teorica, harina_utilizada, merma_masa, merma_tortilla, usuario, fechahora, activo,
  (SELECT CONCAT(nombre,' ',ap_paterno,' ',ap_materno) FROM usuarios INNER JOIN personas ON personas.id = usuarios.id_persona WHERE usuarios.id = tor_bitacora_produccion.usuario)
  FROM
  tor_bitacora_produccion
  WHERE activo = '1' AND id= '$ide'";



  $consulta_folio = mysqli_query($conexion, $cadena_consulta);
  $row_folio = mysqli_fetch_array($consulta_folio);

  $cadena_sucursal = "SELECT nombre FROM sucursales WHERE id = '$row_folio[2]'";
  $consulta_sucursal = mysqli_query($conexion, $cadena_sucursal);
  $row_sucursal = mysqli_fetch_array($consulta_sucursal);

  $cadena_persona = "SELECT nombre, ap_paterno, ap_materno FROM empleados WHERE codigo = '$row_folio[1]'";
  $consulta_persona = sqlsrv_query($conn, $cadena_persona);
  $row_persona = sqlsrv_fetch_array( $consulta_persona, SQLSRV_FETCH_ASSOC);
  $nombre_empleado = $row_persona['nombre'].' '.$row_persona['ap_paterno'].' '.$row_persona['ap_materno'];
  $nombre_empleado=ucwords(strtolower($nombre_empleado));
  if($row_folio[13]==""){
    $empleado = $row_folio[1].'  '.$nombre_empleado;
  }else{
    $empleado = $row_folio[1].' '.$row_folio[13]; 
  }
  

  require_once('../plugins/TCPDF-master/tcpdf.php');
class MYPDF extends TCPDF {

    //Page header
    public function Header() {
        // Logo
        $image_file = '../plugins/TCPDF-master/logo.png';
        $this->Image($image_file, 10, 10, 170, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        //$this->SetFont('helvetica', 'B', 18);
        // Title
        //$this->Cell(0, 15, 'LA MISIÓN SUPERMERCADOS S.A. DE C.V.Hola', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Página '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Angie Villarreal');
$pdf->SetTitle('Formato Tortilleria');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------
// set font
$pdf->SetFont('helvetica', 'B', 12);

// add a page
$pdf->AddPage();

// set some text to print
$html="
<br><br>
<h2 style='text-align:center;'>Bitácora de Producción Diaria SR</h2>
";
$pdf->writeHTML($html, true, false, true, false, 'C');

$html="
<table border=\"0\">
	<tr>
		<td align=\"left\">
			<h3>Sucursal $row_sucursal[0]</h3>
		</td>
		<td align=\"right\">
			<h3>N°. Turno:$row_orden_compra[0]</h3>
		</td>
	</tr>
	<tr>
		<td align=\"left\">
			<h4>Copia para transportista</h4>
		</td>
		<td align=\"right\">
			<h4>Fecha: $row_orden_compra[6]</h4>
		</td>
	</tr>
</table>
";

$pdf->writeHTML($html, true, false, true, false, 'J');

$html="
<hr>
<p>Estimado Proveedor: $row_proveedor[0]<br>Le comunicamos que con la remesa recibida, cuyos datos abajo detallamos determinamos el siguiente:
";
$pdf->writeHTML($html, true, false, true, false, 'J');

$html="
<h2>$row_orden_compra[3]</h2>
";
$pdf->writeHTML($html, true, false, true, false, 'C');

$html = "
<p>Para cualquier aclaración, favor de citar nuestro Folio de Entrada No: $row_nota[0]</p>
";
$pdf->writeHTML($html, true, false, true, false, 'J');

$html = "
<table border=\"0\">
	<tr>
		<td>
			De fecha: $row_orden_compra[6]
		</td>
		<td align=\"right\">
			Su Factura: $row_orden_compra[4] 
		</td>
	</tr>
</table>
";
$pdf->writeHTML($html, true, false, true, false, 'J');

$encabezado_tabla = "
<table border=\"1\">
	<tr>
		<th width=\"20%\">Cantidad</th>
		<th width=\"60%\">Descripción</th>
		<th width=\"20%\">U. M.</th>
	</tr>";

$cadena_detalle = "SELECT cantidad_producto, descripcion, unidad_medida, costo_unitario, total_renglon FROM detalle_carta_faltante WHERE id_carta_faltante = '$row_orden_compra[0]'";
$consulta_detalle = mysqli_query($conexion, $cadena_detalle);
$total_body = "";
while ($row_detalle = mysqli_fetch_array($consulta_detalle)) {
	$renglon = "
	<tr>
		<td>$row_detalle[0]</td>
		<td align=\"left\"> $row_detalle[1]</td>
		<td>$row_detalle[2]</td>
	</tr>
	";
	$total_body = $total_body.$renglon;
}

$footer_tabla="	
</table>
";
$html = $encabezado_tabla.$total_body.$footer_tabla;
$pdf->writeHTML($html, true, false, true, false, 'C');

$html = "<p>Con estas medidas, confirmamos nuestro gran interés por mejorar nuestras ya buenas relaciones comerciales y no dudamos de su colaboración a la presente norma que se traducirá en beneficio para ambos.</p>";

$pdf->writeHTML($html, true, false, true, false, 'J');

$html = "
<table border=\"0\" align=\"center\">
	<tr>
		<td>_______________________</td>
		<td>_______________________</td>
		<td>_______________________</td>
	</tr>
	<tr>
		<td>
			Transportista<br>
			".ucwords(strtolower($row_orden_compra[8]))."
		</td>
		<td>
			Elaboró<br>
			$row_orden_compra[10]
		</td>
		<td>
			Gerencia<br>
		</td>
	</tr>
</table>
";
$pdf->SetY(235);
$pdf->writeHTML($html, true, false, true, false, 'J');

// add a page
$pdf->AddPage();

// set some text to print
$html="
<br><br>
<h2 style='text-align:center;'>CARTA FALTANTE - SOBRANTE</h2>
";
$pdf->writeHTML($html, true, false, true, false, 'C');

$html="
<table border=\"0\">
	<tr>
		<td align=\"left\">
			<h3>Sucursal $row_sucursal[0]</h3>
		</td>
		<td align=\"right\">
			<h3>N°. Folio:$row_orden_compra[0]</h3>
		</td>
	</tr>
	<tr>
		<td align=\"left\">
			<h4>Copia para Almacenista</h4>
		</td>
		<td align=\"right\">
			<h4>Fecha: $row_orden_compra[6]</h4>
		</td>
	</tr>
</table>
";

$pdf->writeHTML($html, true, false, true, false, 'J');

$html="
<hr>
<p>Estimado Proveedor: $row_proveedor[0]<br>Le comunicamos que con la remesa recibida, cuyos datos abajo detallamos determinamos el siguiente:
";
$pdf->writeHTML($html, true, false, true, false, 'J');

$html="
<h2>$row_orden_compra[3]</h2>
";
$pdf->writeHTML($html, true, false, true, false, 'C');

$html = "
<p>Para cualquier aclaración, favor de citar nuestro Folio de Entrada No: $row_nota[0]</p>
";
$pdf->writeHTML($html, true, false, true, false, 'J');

$html = "
<table border=\"0\">
	<tr>
		<td>
			De fecha: $row_orden_compra[6]
		</td>
		<td align=\"right\">
			Su Factura: $row_orden_compra[4] 
		</td>
	</tr>
</table>
";
$pdf->writeHTML($html, true, false, true, false, 'J');

$encabezado_tabla = "
<table border=\"1\">
	<tr>
		<th width=\"10%\">Cantidad</th>
		<th width=\"50%\">Descripción</th>
		<th width=\"10%\">U. M.</th>
		<th width=\"15%\">C. U.</th>
		<th width=\"15%\">C. T.</th>
	</tr>";

$cadena_detalle = "SELECT cantidad_producto, descripcion, unidad_medida, costo_unitario, total_renglon FROM detalle_carta_faltante WHERE id_carta_faltante = '$row_orden_compra[0]'";
$consulta_detalle = mysqli_query($conexion, $cadena_detalle);
$total_body = "";
while ($row_detalle = mysqli_fetch_array($consulta_detalle)) {
	$renglon = "
	<tr>
		<td>$row_detalle[0]</td>
		<td align=\"left\"> $row_detalle[1]</td>
		<td>$row_detalle[2]</td>
		<td>$ $row_detalle[3]</td>
		<td>$ $row_detalle[4]</td>
	</tr>
	";
	$total_body = $total_body.$renglon;
}

$footer_tabla="
	<tr>
		<td colspan=\"4\" align=\"right\">
			TOTAL DIFERENCIA: &nbsp;
		</td>
		<td>$ $row_orden_compra[9]</td>
	</tr>
</table>
";
$html = $encabezado_tabla.$total_body.$footer_tabla;
$pdf->writeHTML($html, true, false, true, false, 'C');

$html = "<p>Con estas medidas, confirmamos nuestro gran interés por mejorar nuestras ya buenas relaciones comerciales y no dudamos de su colaboración a la presente norma que se traducirá en beneficio para ambos.</p>";

$pdf->writeHTML($html, true, false, true, false, 'J');

$html = "
<table border=\"0\" align=\"center\">
	<tr>
		<td>_______________________</td>
		<td>_______________________</td>
		<td>_______________________</td>
	</tr>
	<tr>
		<td>
			Transportista<br>
			".ucwords(strtolower($row_orden_compra[8]))."
		</td>
		<td>
			Elaboró<br>
			$row_orden_compra[10]</td>
		<td>
			Gerencia<br>
		</td>
	</tr>
</table>
";
$pdf->SetY(235);
$pdf->writeHTML($html, true, false, true, false, 'J');

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('example_003.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+


?>
<!DOCTYPE html>
<html lang="es">
<head>
</head>
 <style>
  * {
    font-size: 13px;
    font-family: 'Arial';
  }
  td,
  th,
  tr,
  table {
    border-top: 0px;
    border-collapse: collapse;
  }
  
  td.producto,
  th.producto {
    width: 90px;
    max-width: 100px;
  }
  
  td.cantidad,
  th.cantidad {
    width: 50px;
    max-width: 50px;
    word-break: break-all;
  }
  
  td.precio,
  th.precio {
    width: 40px;
    max-width: 40px;
    word-break: break-all;
  }
  
  .centrado {
    text-align: center;
    align-content: center;
    font-weight: bold;
  }
  
  .ticket {
    width: 300px;
    max-width: 400px;
  }
  
  img {
    max-width: inherit;
    width: inherit;
  }
  @media print{
    .oculto-impresion, .oculto-impresion *{
      display: none !important;
    }
  }
</style>
<body>
   <div style="padding: 5px; margin: 0px;" id="ticket" class="ticket">
    <p class="centrado">LA MISIÓN SUPERMERCADOS S.A DE C.V.
    <br>INCIDENCIAS</p>
    <table width='100%' border="0">
      <tr>
          <td align='left'>Se aplica el presente reporte a: <br><br><b><?php echo $empleado; ?></b><br> del departamento de:<b> <?php echo $row_folio[2]; ?><br><br></b>
          En la Sucursal: <b> <?php echo $row_folio[4]; ?></b> debido a: <br><b><?php echo $row_folio[7]; ?></b> <br><br></td>
      </tr>
      <tr>
      <td>
        Obteniendo una sanción de tipo: <b><?php echo $row_folio[12]; ?>.</b></td>
      </tr>
      <tr>
          <td colspan="2">Comentario Vigilante:<br><b><?php echo $row_folio[6]; ?></b><br><br></td>
      </tr>
      <tr>
          <td colspan="2">Fecha:<br><b><?php echo $row_folio[16]; ?></b><br><br></td>
      </tr>
      <tr>
          <td colspan="2">Comentario Gerente:<br><b><?php echo $row_folio[14]; ?></b><br><br></td>
      </tr>
      <tr>
          <td>Gerente: <b><?php echo $row_folio[15]; ?></b><br></td>
      </tr>
      <tr>
          <td colspan="2">Vigilante: <b><?php echo $row_folio[11]; ?></b></td>
      </tr>
    </table>
   </div>
   <button class="oculto-impresion" onclick="imprimir()">Imprimir</button>
<script >
  function imprimir() {
      window.print();
 }
</script>
</body>
</html>