<?php
include '../global_settings/conexion_oracle.php';
include '../global_seguridad/verificar_sesion.php';

$folio = $_POST['folio'];
$cadena_detalle = "SELECT id, id_sucursal, tipo_movimiento, folio_movimiento, fecha_movimiento, artc_articulo, artc_descripcion, cantidad, proveedor, teorico, ventas, dias_inventario FROM registro_ofertas_detalle where id_registro_ofertas = '$folio' AND activo = '1'";
$consulta_detalle = mysqli_query($conexion, $cadena_detalle);
//echo $cadena_detalle;
$body = "";
$encabezado = "
  <div class='table-responsive'>
    <form method='POST' id='form-tabla'>
        <input type='hidden' name='folio' id='folio' value ='$folio'>
        <table id='lista_teoricos' class='table table-striped table-bordered' cellspacing='0' width='100%'>
            <thead>
            <tr>
              <th style='width:2%'>#</th>
              <th style='width:5%'>Sucursal</th>
              <th style='width:5%'>T.Mov.</th>
              <th style='width:5%'>Folio</th>
              <th style='width:8%'>Fecha</th>
              <th style='width:10%'>Codigo</th>
              <th>Descripcion</th>
              <th style='width:5%'>Cantidad</th>
              <th>Proveedor</th>
              <th style='width:5%'>Teórico</th>
              <th style='width:5%'>Ventas (x̄)</th>
              <th style='width:5%'>Días Inv.</th>
          </tr>
          </thead>
          <tbody>";
$i = 1;
while ($row = mysqli_fetch_row($consulta_detalle)) {
  $fila = "	
            <tr>
              <td style='width:2%'>$i</td>
              <td style='width:5%'>$row[1]</td>
              <td style='width:5%'>$row[2]</td>
              <td style='width:5%'>$row[3]</td>
              <td style='width:8%'>$row[4]</td>
              <td style='width:10%'>$row[5]</td>
              <td>$row[6]</td>
              <td style='width:5%'>$row[7]</td>
              <td>$row[8]</td>
              <td style='width:5%'>$row[9]</td>
              <td style='width:5%'>$row[10]</td>
              <td style='width:5%'>$row[11]</td>
            </tr>";
  $body = $body . $fila;
  $i = $i + 1;
}
$footer = "
	        </tbody>  
      </table>
    </form>
	</div>";

$tabla = $encabezado . $body . $footer;

echo $tabla;
