<?php
include '../global_seguridad/verificar_sesion.php';

$folioDM = $_POST['folioDM'];
$cadenaFolios = "SELECT ne.id, ne.folio_mov, ne.tipo_mov, ne.diferencia, ne.dif_impuestos, ne.id_sucursal 
                  FROM notas_entrada as ne INNER JOIN alb_foliomov as alb ON ne.folio_mov = alb.modn_folio AND ne.tipo_mov = alb.modc_tipomov AND ne.id_sucursal = alb.id_sucursal
                  WHERE alb.ficha_entrada = '$folioDM'";
$consultaFolios = mysqli_query($conexion,$cadenaFolios);
$rowFolios = mysqli_fetch_array($consultaFolios);

$cadena_detalle = "SELECT ne.folio_mov, ne.tipo_mov, ne.diferencia 
FROM notas_entrada as ne INNER JOIN alb_foliomov as alb ON ne.folio_mov = alb.modn_folio AND ne.tipo_mov = alb.modc_tipomov AND ne.id_sucursal = alb.id_sucursal
WHERE alb.ficha_entrada = '$folioDM'";
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
                <th width='10%'>Ver</th>
              </tr>
          </thead>
	        <tbody>";
while ($row = mysqli_fetch_row($consulta_detalle)) {
  $ver ="<center><a href='../mFacturasEntradasNew/nota_cargo.php?folio=$rowFolios[1]&tipo_mov=$rowFolios[2]&sucursal=$rowFolios[5]' target='blank' class='btn btn-primary'><i class='fa fa-search' aria-hidden=true'></i></a>";
  $fila = "	
                <tr>
                  <td>$row[0]</td>
                  <td>$row[1]</td>
                  <td>$row[2]</td>
                  <td>$ver</td>
                </tr>";
  $body = $body . $fila;
}
$footer = "
	        </tbody>  
      </table>
	</div>";

$tabla = $encabezado . $body . $footer;

echo $tabla;
