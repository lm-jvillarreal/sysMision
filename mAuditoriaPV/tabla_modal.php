<?php 
include '../global_settings/conexion_oracle.php';
include '../global_seguridad/verificar_sesion.php';

$folio = $_POST['folio'];
$cadena_detalle = "SELECT * FROM auditoria_pv WHERE folio = '$folio' and usuario = '$id_usuario'";
$consulta_detalle = mysqli_query($conexion,$cadena_detalle);
//echo $cadena_detalle;
$body = "";
$encabezado = "
  <div class='table-responsive'>
    <form method='POST' id='form-tabla'>
        <input type='hidden' name='folio' id='folio' value ='$folio'>
        <table id='lista_teoricos' class='table table-striped table-bordered' cellspacing='0' width='192%'>
            <thead>
              <tr>
                <th width='2%'></th>
                <th width='5%'>Codigo</th>
                <th>Descripcion</th>
                <th width='4%'>U. Entrada</th>
                <th width='4%'>T. Mov</th>
                <th width='4%'>Folio</th>
                <th width='4%'>Compra</th>
                <th>Proveedor</th>
                <th width='9%'>Depto.</th>
                <th width='9%'>Fam.</th>
                <th width='4%'>U. C.</th>
                <th width='4%'>U. Emp.</th>
                <th width='4%'>Ventas</th>
                <th width='4%'>% Falt.</th>
                <th width='4%'>Teórico</th>
                <th width='4%'>Faltante</th>
                <th width='4%'>F. Cajas</th>
                <th width='4%'>Dias Inv.</th>
                <th width='4%'>Meses Inv.</th>
                <th width='4%'>Termina</th>
              </tr>
          </thead>
	        <tbody>";
	        	while($row = mysqli_fetch_row($consulta_detalle))
              {
                $eliminar = "<center><a href='#' class='btn btn-danger' onclick='eliminar_codigo($row[4])'><i class='fa fa-trash fa-lg' aria-hidden='true'></i></a></center>";
                if($row[9]=='0' || $row[9]==NULL || $row[15]=='0' || $row[15]==NULL){
                  $porcentaje='0';
                }else{
                  $porcentaje = $porcentaje = (1-($row[9]/$row[15]))*100;
                  $porcentaje = round($porcentaje,2);
                }
                
                $fecha_termina = strtotime($fecha."+ $row[19] days");
                $fecha_termina = date("d/m/Y",$fecha_termina);
                $fila = "	
                <tr>
                  <td>$row[0]</td>
                  <td>$row[3]</td>
                  <td>$row[4]</td>
                  <td>$row[6]</td>
                  <td>$row[7]</td>
                  <td>$row[8]</td>
                  <td>$row[9]</td>
                  <td>$row[10]</td>
                  <td>$row[11]</td>
                  <td>$row[12]</td>
                  <td>$row[13]</td>
                  <td>$row[14]</td>
                  <td>$row[15]</td>
                  <td>$porcentaje</td>
                  <td>$row[16]</td>
                  <td>$row[17]</td>
                  <td>$row[18]</td>
                  <td>$row[19]</td>
                  <td>$row[20]</td>
                  <td>$fecha_termina</td>
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