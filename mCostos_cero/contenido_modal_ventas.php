<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

$codigo = $_POST['articulo'];

$cadena_salida = "SELECT 
(SELECT COUNT(*) FROM INV_RENGLONES_MOVIMIENTOS WHERE MODC_TIPOMOV = 'SIROTA' AND ARTC_ARTICULO = '$codigo' AND ALMN_ALMACEN = '1') \"SIROTA DO\",
(SELECT COUNT(*) FROM INV_RENGLONES_MOVIMIENTOS WHERE MODC_TIPOMOV = 'SALXVE' AND ARTC_ARTICULO = '$codigo' AND ALMN_ALMACEN = '1') \"SALXVE DO\",
(SELECT COUNT(*) FROM INV_RENGLONES_MOVIMIENTOS WHERE MODC_TIPOMOV = 'SIROTA' AND ARTC_ARTICULO = '$codigo' AND ALMN_ALMACEN = '2') \"SIROTA ARB\",
(SELECT COUNT(*) FROM INV_RENGLONES_MOVIMIENTOS WHERE MODC_TIPOMOV = 'SALXVE' AND ARTC_ARTICULO = '$codigo' AND ALMN_ALMACEN = '2') \"SALXVE ARB\",
(SELECT COUNT(*) FROM INV_RENGLONES_MOVIMIENTOS WHERE MODC_TIPOMOV = 'SIROTA' AND ARTC_ARTICULO = '$codigo' AND ALMN_ALMACEN = '3') \"SIROTA VILL\",
(SELECT COUNT(*) FROM INV_RENGLONES_MOVIMIENTOS WHERE MODC_TIPOMOV = 'SALXVE' AND ARTC_ARTICULO = '$codigo' AND ALMN_ALMACEN = '3') \"SALXVE VILL\",
(SELECT COUNT(*) FROM INV_RENGLONES_MOVIMIENTOS WHERE MODC_TIPOMOV = 'SIROTA' AND ARTC_ARTICULO = '$codigo' AND ALMN_ALMACEN = '4') \"SIROTA ALL\",
(SELECT COUNT(*) FROM INV_RENGLONES_MOVIMIENTOS WHERE MODC_TIPOMOV = 'SALXVE' AND ARTC_ARTICULO = '$codigo' AND ALMN_ALMACEN = '4') \"SALXVE ALL\" 

FROM DUAL";

$st = oci_parse($conexion_central, $cadena_salida);
oci_execute($st);
$row_ue = oci_fetch_row($st);
 //echo $cadena_ue;

$imprimir = '
<div class="container">
	<div class="row">
        <div class="col-md-9">
            <div class="table-responsive">
                <table id="detalle_cc" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <th width="5%"></th>
                        <th>DO</th>
                        <th>ARB</th>
                        <th>VILL</th>
                        <th>ALL</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>SIROTA</td>
                            <td>'.$row_ue[0].'</td>
                            <td>'.$row_ue[2].'</td>
                            <td>'.$row_ue[4].'</td>
                            <td>'.$row_ue[6].'</td>
                        </tr>
                        <tr>
                            <td>SALXVE</td>
                            <td>'.$row_ue[1].'</td>
                            <td>'.$row_ue[3].'</td>
                            <td>'.$row_ue[5].'</td>
                            <td>'.$row_ue[7].'</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
	</div>
</div>
';

echo $imprimir;
?>