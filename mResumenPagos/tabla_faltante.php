<?php
include '../global_seguridad/verificar_sesion.php';


$folioF = $_POST['folioF'];
$cadenaFolios = "SELECT c.id, 
                  c.tipo_orden,
                  c.total_diferencia,
                  c.activo
                  FROM carta_faltante AS c INNER JOIN libro_diario AS l  ON c.id_orden =l.orden_compra
                  WHERE l.numero_nota ='$folioF'
                  group by (c.id)";
$consultaFolios = mysqli_query($conexion,$cadenaFolios);
$rowFolios = mysqli_fetch_array($consultaFolios);

$cadena_detalle = "SELECT c.id, 
c.tipo_orden,
c.total_diferencia,
c.activo
FROM carta_faltante AS c INNER JOIN libro_diario AS l  ON c.id_orden =l.orden_compra
WHERE l.numero_nota ='$folioF'
group by (c.id)";
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
  $ver ="<center><a href='../mCartas_faltantes/carta_faltante_pdf.php?id=$rowFolios[0]' target='blank' class='btn btn-primary'><i class='fa fa-search' aria-hidden=true'></i></a>";
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
