<?php
include '../global_seguridad/verificar_sesion.php';

$folio = $_POST['folio'];
$cadena_detalle = "SELECT modn_folio, modc_tipomov, monto FROM alb_foliomov WHERE ficha_entrada = '$folio' AND (modc_tipomov='ENTCOC' OR modc_tipomov = 'ENTSOC')";
$consulta_detalle = mysqli_query($conexion, $cadena_detalle);
//echo $cadena_detalle;
$body = "";
$encabezado = "
  <div class='table-responsive'>
        <table id='lista_folios' class='table table-striped table-bordered' cellspacing='0' width='100%'>
            <thead>
              <tr>
                <th width='10%'>Folio</th>
                <th>Tipo Movimiento</th>
                <th width='10%'>Total</th>
              </tr>
          </thead>
	        <tbody>";
while ($row = mysqli_fetch_row($consulta_detalle)) {
  $fila = "	
                <tr>
                  <td>$row[0]</td>
                  <td>$row[1]</td>
                  <td>$row[2]</td>
                </tr>";
  $body = $body . $fila;
}
$footer = "
	        </tbody>  
      </table>
	</div>";

$tabla = $encabezado . $body . $footer;

echo $tabla;
