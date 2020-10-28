<?php
include '../global_settings/conexion_oracle.php';
include '../global_seguridad/verificar_sesion.php';

$folio = $_POST['folio'];
$cadena_detalle = "SELECT codigo, descripcion, formato, cantidad, hora FROM detalle_solicitud where id_solicitud = '$folio'";
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
              <td width='10%'>Código</td>
              <td>Descripción</td>
              <td width='5%'>Formato</td>
              <td width='5%'>Cantidad</td>
              <td width='5%'>Hora</td>
          </tr>
          </thead>
          <tbody>";
$i = 1;
while ($row = mysqli_fetch_row($consulta_detalle)) {
  $fila = "	
            <tr>
              <td width='10%'>$row[0]</td>
              <td>$row[1]</td>
              <td width='5%'>$row[2]</td>
              <td width='5%'>$row[3]</td>
              <td width='5%'>$row[4]</td>
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
