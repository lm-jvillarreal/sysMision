<?php
error_reporting(E_ALL ^ E_NOTICE);
include("../global_settings/conexion_oracle.php");
//include("conexion.php");
date_default_timezone_set('America/Monterrey');
$fecha = date('Y-m-d');
$hora = date('H:i:s');
$sucursal = $_POST['sucursal'];
$familia = $_POST['familia'];
$array = $_POST['array'];
$arra = explode(',', $array);
$cantidad = count($arra);
$departamento = $_POST['departamento'];

$or="";
if ($departamento == "" && $familia == "") {
	for ($i=1; $i < $cantidad; $i++) { 
		$consulta = " OR ARTC_ARTICULO = '$arra[$i]'";
		$or = $or . $consulta;
	}
		$consulta_principal  = "SELECT
									ARTC_ARTICULO,
									ARTC_DESCRIPCION,
									COM_FAMILIAS.FAMC_DESCRIPCION,
									(
										SELECT
											FAMC_DESCRIPCION
										FROM
											COM_FAMILIAS F
										WHERE
											F.FAMC_FAMILIA = COM_FAMILIAS.FAMC_FAMILIAPADRE
									)
								FROM
									COM_ARTICULOS
								INNER JOIN COM_FAMILIAS ON COM_FAMILIAS.FAMC_FAMILIA = COM_ARTICULOS.ARTC_FAMILIA
								WHERE
									(
										ARTC_ARTICULO = '$arra[0]'".$or."
									)";	
}

if ($departamento != "") {
	$consulta_principal = "SELECT
							ARTC_ARTICULO,
							ARTC_DESCRIPCION,
							COM_FAMILIAS.FAMC_DESCRIPCION,
							(
								SELECT
									FAMC_DESCRIPCION
								FROM
									COM_FAMILIAS F
								WHERE
									F.FAMC_FAMILIA = COM_FAMILIAS.FAMC_FAMILIAPADRE
							)
						FROM
							COM_ARTICULOS
						INNER JOIN COM_FAMILIAS ON COM_FAMILIAS.FAMC_FAMILIA = COM_ARTICULOS.ARTC_FAMILIA
						WHERE
							COM_FAMILIAS.FAMC_FAMILIAPADRE = '$departamento'";
}

if ($familia != "") {
	$consulta_principal = "SELECT
							ARTC_ARTICULO,
							ARTC_DESCRIPCION,
							COM_FAMILIAS.FAMC_DESCRIPCION,
							(
								SELECT
									FAMC_DESCRIPCION
								FROM
									COM_FAMILIAS F
								WHERE
									F.FAMC_FAMILIA = COM_FAMILIAS.FAMC_FAMILIAPADRE
							)
						FROM
							COM_ARTICULOS
						INNER JOIN COM_FAMILIAS ON COM_FAMILIAS.FAMC_FAMILIA = COM_ARTICULOS.ARTC_FAMILIA
						WHERE
							COM_ARTICULOS.ARTC_FAMILIA = '$familia'";
}
				//echo "$consulta_principal";
		$st = oci_parse($conexion_central, $consulta_principal);
		oci_execute($st);

        
 ?>

	<script>
		$(document).ready(function() {
			$('#example2').dataTable({

				"lengthMenu":
					[[-1], [ "All"]],
				
				 "language": {
				"url": "../assets/js/Spanish.json"
				 }
			});
		});
	</script>
	<div class="table-responsive">
	    <table id="example2" class="table table-striped table-bordered" cellspacing="0" width="100%">
	      <thead>
	        <tr>
        		<th>Codigo</th>
        		<th>Descripcion</th>
	          	<th>Existencia</th>
	        </tr>
	      </thead>
	      <body>
	        <?php
	        while($row = oci_fetch_row($st))
	        {
	        	$qry_existencia = "SELECT spin_articulos.fn_existencia_disponible_todos (
									13,
									NULL,
									NULL,
									1,
									1,
									'$sucursal',
									'$row[0]'
								) FROM dual";
				$ste = oci_parse($conexion_central, $qry_existencia);
				oci_execute($ste);
				$row_existencia = oci_fetch_row($ste);
	        ?>
	          <tr>
	          	<td>
	          		<?php echo $row[0] ?>
	          	</td>
	          	<td>
	          		<?php echo $row[1] ?>
	          	</td>
	            <td>
	              <?php echo $row_existencia[0]; ?>
	            </td>
	          </tr>
	          <?
	        }
	        ?>
	    </table>
	</div>
</body>
