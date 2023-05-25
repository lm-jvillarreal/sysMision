<?php 
include '../global_settings/conexion_oracle.php';
include '../global_seguridad/verificar_sesion.php';

$folio = $_POST['folio'];
$cadena_detalle = "SELECT artc_articulo, artc_descripcion, artc_familia, artc_depto, id FROM monitoreo_teoricos WHERE folio = '$folio'";
$consulta_detalle = mysqli_query($conexion,$cadena_detalle);
//echo $cadena_detalle;
$body = "";
$encabezado = "
  <div class='table-responsive'>
    <form method='POST' id='form-tabla'>
        <input type='hidden' name='folio' id='folio' value ='$folio'>
        <table id='lista_teoricos' class='table table-striped table-bordered' cellspacing='0' width='100%'>
	        <thead>
	            <tr>
                <th width='10%'>Articulo</th>
                <th width='25%'>Descripción</th>
                <th width='10%'>Familia</th>
                <th width='15%'>Depto.</th>
                <th width='5%'>DO</th>
                <th width='5%'>ARB</th>
                <th width='5%'>VILL</th>
                <th width='5%'>ALL</th>
                <th width='5%'>LP</th>
                <th width='5%'>MM</th>
                <th width='5%'>CEDIS</th>
                <th width='5%'>ROPA</th>
                <th width='5%'></th>
                <th width='4%'></th>
                <th width='4%'></th>
	            </tr>
	        </thead>
	        <tbody>";
	        	while($row = mysqli_fetch_row($consulta_detalle))
              {
                $cadena_existencia = "SELECT 
                spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, 1, '$row[0]'),
                spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, 2, '$row[0]'), 
                spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, 3, '$row[0]'), 
                spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, 4, '$row[0]'),
                spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, 5, '$row[0]'),
                spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, 6, '$row[0]'),
                spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, 99, '$row[0]'),
                spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, 203, '$row[0]')
              FROM 
                dual";
                $st = oci_parse($conexion_central, $cadena_existencia);
                oci_execute($st);
                $row_existencia = oci_fetch_row($st);
                $total = $row_existencia[0]+$row_existencia[1]+$row_existencia[2]+$row_existencia[3]+$row_existencia[4]+$row_existencia[5];
                $eliminar = "<center><a href='#' class='btn btn-danger' onclick='eliminar_codigo($row[4])'><i class='fa fa-trash fa-lg' aria-hidden='true'></i></a></center>";
                $baja = "<center><a href='#' class='btn btn-warning' onclick='baja($row[4])'$solo_lectura><i class='fa fa-arrow-down fa-lg' aria-hidden='true'></i></a></center>";
                $fila = "	
                <tr>
                  <td>
                    $row[0]
                  </td>
                  <td>
                    $row[1]
                  </td>
                  <td>
                    $row[2]
                  </td>
                  <td>
                    $row[3]
                  </td>
                  <td>
                    $row_existencia[0]
                  </td>
                  <td>
                    $row_existencia[1]
                  </td>
                  <td>
                    $row_existencia[2]
                  </td>
                  <td>
                    $row_existencia[3]
                  </td>
                  <td>
                    $row_existencia[4]
                  </td>
                  <td>
                    $row_existencia[5]
                  </td>
                  <td>
                    $row_existencia[6]
                  </td>
                  <td>
                    $row_existencia[7]
                  </td>
                  <td>
                    $total
                  </td>
                  <td>
                    $eliminar
                  </td>
                  <td>
                    $baja
                  </td>
                </tr>";
                $body = $body.$fila;
              }
$footer = "
	        </tbody>  
      </table>
    </form>
	</div>";

$tabla = $encabezado.$body.$footer;

echo $tabla;