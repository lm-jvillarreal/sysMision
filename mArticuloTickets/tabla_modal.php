<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

$artc_articulo = $_POST['articulo'];
$inicio = $_POST['inicio'];
$fin = $_POST['fin'];
$sucursal= $_POST['sucursal'];

$cadena_detalle = "SELECT TICC_SUCURSAL, ticn_aaaammddventa, TICN_FOLIO, artc_articulo FROM PV_ARTICULOSTICKET WHERE ticn_aaaammddventa>=$inicio AND ticn_aaaammddventa<=$fin AND ARTC_ARTICULO = '$artc_articulo' AND TICC_SUCURSAL='$sucursal'";
$consulta_detalle = oci_parse($conexion_central, $cadena_detalle);
oci_execute($consulta_detalle);
//echo $cadena_detalle;
$body = "";
$encabezado = "
  <div class='table-responsive'>
        <table id='lista_folios' class='table table-striped table-bordered' cellspacing='0' width='100%'>
            <thead>
              <tr>
                <th>Sucursal</th>
                <th>Folio</th>
                <th>Consecutivo</th>
                <th>Artículo</th>
              </tr>
          </thead>
	        <tbody>";
while ($row = oci_fetch_row($consulta_detalle)) {
  $fila = "	
                <tr>
                  <td>$row[0]</td>
                  <td>$row[1]</td>
                  <td>$row[2]</td>
                  <td>$row[3]</td>
                </tr>";
  $body = $body . $fila;
}
$footer = "
	        </tbody>  
      </table>
	</div>";

$tabla = $encabezado . $body . $footer;

echo $tabla;
