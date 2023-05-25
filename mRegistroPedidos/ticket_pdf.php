<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_sucursales.php';

if($id_sede=='1'){
  $conexion_central = $conexion_do;
}elseif($id_sede=='2'){
  $conexion_central = $conexion_arb;
}elseif($id_sede=='3'){
  $conexion_central = $conexion_vill;
}elseif($id_sede=='4'){
  $conexion_central = $conexion_all;
}

$folio_pedido=$_GET['flp'];
$cadenaFolio="SELECT 
                NOMBRE_CLIENTE, 
                TELEFONO_CLIENTE, 
                COLONIA_CLIENTE, 
                PEDIDO_FOLIOTICKET, 
                CALLE_CLIENTE, 
                NUMERO_CLIENTE, 
                ENTRECALLES_CLIENTE, 
                REFERENCIA_DOMICILIO, 
                DATE_FORMAT(HORA_FINALSURTIDO,'%H:%i:%s'), 
                PEDIDO_FOLIOTICKET, 
                (SELECT CONCAT(p.nombre,' ',p.ap_paterno) FROM personas as p INNER JOIN usuarios as u ON p.id=u.id_persona WHERE u.id=pv_pedidos.ID_TOMAPEDIDO),
                TIPO_PEDIDO
              FROM pv_pedidos 
                WHERE ID='$folio_pedido'";
$consultaPedido=mysqli_query($conexion,$cadenaFolio);
$rowPedido=mysqli_fetch_array($consultaPedido);
$date = date_create($fecha);
$format_fecha = date_format($date, 'd/m/Y');

$prefijo=substr($rowPedido[3],0,8);
$consecutivo=substr($rowPedido[3],8);

require_once('../plugins/TCPDF-master/tcpdf.php');
class MYPDF extends TCPDF {

    //Page header
    public function Header() {
        // Logo
        $image_file = '../plugins/TCPDF-master/logo.png';
        $this->Image($image_file, 10, 10, 170, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
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
$pdf->SetAuthor('Josué Villarreal');
$pdf->SetTitle('Pedidos a Domicilio');
$pdf->SetSubject('Detalle del pedido');
$pdf->SetKeywords('La Misión, Pedidos a Domicilio');

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
$pdf->SetLeftMargin(5);
$pdf->SetRightMargin(5);

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
$pdf->SetFont('helvetica', 'B', 11);

// add a page
$pdf->AddPage();

// set some text to print
$html="
<br>
<h2 style='text-align:center;'>DETALLE DE PEDIDO</h2>
<h3 style='text-align:left;'>$rowPedido[2]</h3>
";
$pdf->writeHTML($html, false, false, true, false, 'C');

$html="
<table border=\"0\">
	<tr>
    <td align=\"left\">
      <h3>N°. Folio: $folio_pedido</h3>
    </td>
    <td align=\"right\">
      <h4>Sucursal: $nombre_sede</h4>
    </td>
	</tr>
	<tr>
		<td align=\"left\">
			<h4>Fecha: $format_fecha $rowPedido[8]</h4>
    </td>
    <td align=\"right\">
			<h4>Ticket: $rowPedido[9]</h4>
    </td>
  </tr>
  <tr>
		<td align=\"left\">
			<h4>Método de pago: $rowPedido[11]</h4>
    </td>
    <td align=\"right\">
			Cajas:___________
    </td>
	</tr>
</table>
<hr>
<table>
  <tr>
    <td width=\"75%\">Cliente: $rowPedido[0]</td>
    <td width=\"25%\">Tel: $rowPedido[1]</td>
  </tr>
  <tr>
    <td width=\"100%\">Dirección: $rowPedido[4], $rowPedido[5], $rowPedido[2] | Entre calles: $rowPedido[6] | Referencia: $rowPedido[7]</td>
  </tr>
</table>
<hr>
";

$pdf->writeHTML($html, true, false, true, false, 'J');

$encabezado_tabla = "
<table border=\"1\" style=\"font-size: small;\">
	<tr>
		<th width=\"10%\">CANT.</th>
    <th width=\"20%\">ARTICULO</th>
    <th width=\"60%\">DESCRIPCION</th>
    <th width=\"10%\">PRECIO</th>
    </tr>";

$cadenaDetalle="SELECT 
                  TO_CHAR(ARTN_CANTIDAD,'fm9990.000'), 
                  ARTC_ARTICULO, 
                  (SELECT TRIM( ARTC_DESCRIPCION ) FROM PVS_ARTICULOS WHERE ARTC_ARTICULO = PVS_ARTICULOSTICKET.ARTC_ARTICULO) 
                  DESCRIPCION, 
                  TO_CHAR(( ARTN_CANTIDAD * ARTN_PRECIOVENTA ) + ARTN_MONTO_IMPUESTOS, 'fm9990.00') PRECIO 
                FROM
                  PVS_ARTICULOSTICKET 
                WHERE
                  TICN_AAAAMMDDVENTA = $prefijo
                  AND TICN_FOLIO = $consecutivo
                  ORDER BY
                  ARTN_CONSECUTIVO ASC";
$consultaDetalle = oci_parse($conexion_central, $cadenaDetalle);
oci_execute($consultaDetalle);
$body_tabla="";
while($rowDetalle = oci_fetch_row($consultaDetalle)){
  $body_tabla=$body_tabla."<tr>
                            <td height=\"15\">$rowDetalle[0]</td>
                            <td height=\"15\">$rowDetalle[1]</td>
                            <td height=\"15\" align=\"left\">&nbsp;$rowDetalle[2]</td>
                            <td height=\"15\">$rowDetalle[3]</td>
                          </tr>";
}
$footer_tabla="	
</table>
";
$html = $encabezado_tabla.$body_tabla.$footer_tabla;
$pdf->writeHTML($html, false, false, true, false, 'C');

$html = "
<p style=\"font-size: xx-small;\">Por medio del presente ticket, el cliente asume la responsabilidad total del pedido hecho en cuestión a LA MISION SUPERMECADOS S.A. DE C.V. el día $format_fecha con el # de pedido $folio_pedido aceptando el listado de productos con el monto total previamente acordado, el cual está dispuesto a pagar en su totalidad cuando la mercancía se entrega en el domicilio, bajo el nombre de $rowPedido[0].</p>
<p style=\"font-size: xx-small;\">Nuestro horario de entrega a domicilio es solamente para sábados y domingos de las 10:00 a las 17:00 horas, sin embargo, puede variar según el horario disponible al momento de confirmar su pedido.</p>
<p style=\"font-size: xx-small;\">Aclaración importante para este servicio:  no se cuenta con devoluciones en el momento de los productos previamente autorizados en el pedido, por eso es importante que firmar el documento de entrega y realizar una inspección física a los productos para garantizar la entrega. Para cualquier aclaración favor de solicitarlo de manera presencial en nuestros horarios hábiles en la sucursal Díaz Ordaz, localizada en Boulevard Díaz Ordaz No. 901 Colonia Centro, en el departamento de Servicio al Cliente; para eso, es importante conservar su ticket del pedido y presentarlo físicamente. Ahí se le informará el proceso a seguir con la devolución, sea en tipo cupón/vale o en efectivo.</p>
";
$pdf->SetY(213);
$pdf->writeHTML($html, true, false, true, false, 'J');

$html = "
<table border=\"0\" align=\"left\">
    <tr>
      <td width=\"33%\" align=\"left\">
          Transportista: _________________
      </td>
      <td width=\"33%\" align=\"center\">
          Elaboró: $rowPedido[10]
      </td>
      <td width=\"34%\" align=\"right\">
          Cliente: ____________________
      </td>
    </tr>
</table>
";
$pdf->SetY(249);
$pdf->writeHTML($html, false, false, true, false, 'L');
// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('Pedido - '.$folio_pedido.'.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>