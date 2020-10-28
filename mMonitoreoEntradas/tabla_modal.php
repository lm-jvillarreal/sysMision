<?php
include '../global_settings/conexion_oracle.php';
include '../global_seguridad/verificar_sesion.php';

$folio_orden = $_POST['folio_orden'];
$cadena_detalle = "SELECT 
                      ROCN_RENGLON, 
                      ARTC_ARTICULO, 
                      ROCC_DESCRIPCION, 
                      artc_unimedida,
                      ROCN_CANTIDAD, 
                      ROCN_CANTSURTIDA,
                      ordn_orden
                    FROM  com_renglones_ordenes_compra WHERE ORDN_ORDEN = '$folio_orden'";
$consulta_detalle = oci_parse($conexion_central, $cadena_detalle);
oci_execute($consulta_detalle);
//echo $cadena_detalle;
$body = "";
$encabezado = "
  <div class='table-responsive'>
    <form method='POST' id='form-tabla'>
        <input type='hidden' name='folio' id='folio' value ='$folio_orden'>
        <table id='lista_oc' class='table table-striped table-bordered' cellspacing='0' width='100%'>
            <thead>
            <tr>
              <th width='5%'>#</th>
              <th width='10%'>O.C.</th>
              <th width='5%'>Artículo</th>
              <th>Descripción</th>
              <th width='10%'>U.M.</th>
              <th width='10%'>Cant. Esp.</th>
              <th width='10%'>Cant. Surt.</th>
              <th width='10%'>Diferencia</th>
              <th width='10%'>T. Dif.</th>
            </tr>
          </thead>
          <tbody>";
$i = 1;
while ($row = oci_fetch_row($consulta_detalle)) {
  $diferencia = $row[5]-$row[4];
  if($diferencia==0){
    $tipo_dif = "NA";
  }elseif($diferencia>0){
    $tipo_dif = "SOBRANTE";
  }elseif($diferencia<0){
    $tipo_dif="FALTANTE";
  }
  $fila = "	
            <tr>
              <td width='5%'>$row[0]</td>
              <td width='10%'>$row[6]</th>
              <td width='10%'>$row[1]</td>
              <td>$row[2]</th>
              <td width='5%'>$row[3]</td>
              <td width='10%'>$row[4]</td>
              <td width='10%'>$row[5]</td>
              <td width='10%'>$diferencia</td>
              <td width='10%'>$tipo_dif</td>
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
