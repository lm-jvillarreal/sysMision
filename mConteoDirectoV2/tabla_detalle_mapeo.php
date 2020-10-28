<?php
		//include '../global_settings/conexion_pruebas.php';
		include '../global_seguridad/verificar_sesion.php';
		$id_mapeo = $_POST['id_mapeo'];
		$qry = "SELECT
					inv_detalle_mapeo.codigo_producto,
					inv_detalle_mapeo.descripcion,
					inv_detalle_mapeo.id,
					inv_detalle_mapeo.consecutivo_mueble,
					inv_detalle_mapeo.estante,
					inv_captura.cantidad
				FROM
					inv_detalle_mapeo
				LEFT JOIN inv_captura ON inv_captura.id_detalle_mapeo = inv_detalle_mapeo.id
					
				WHERE
					inv_detalle_mapeo.id_mapeo = '$id_mapeo' 
					AND inv_captura.id_mapeo = '$id_mapeo'
				ORDER BY
					inv_detalle_mapeo.id desc
				limit 20";
				//echo "$qry";
		$exQry = mysqli_query($conexion, $qry);
		date_default_timezone_set('America/Monterrey');
		$fecha = date('Y-m-d');
 ?>
	<script>
		$(document).ready(function() {
			$('#example').dataTable({
				"dom": 'Bfrtip',
			    buttons: [{
			        extend: 'pageLength',
			        text: 'Registros',
			        className: 'btn btn-default'
			      },
			      {
			        extend: 'excel',
			        text: 'Exportar a Excel',
			        className: 'btn btn-default',
			        title: 'NuevoMapeo',
			        exportOptions: {
			          columns: ':visible'
			        }
			      },
			      {
			        extend: 'pdf',
			        text: 'Exportar a PDF',
			        className: 'btn btn-default',
			        title: 'NuevoMapeo',
			        exportOptions: {
			          columns: ':visible'
			        }
			      },
			      {
			        extend: 'copy',
			        text: 'Copiar registros',
			        className: 'btn btn-default',
			        copyTitle: 'Ajouté au presse-papiers',
			        copyKeys: 'Appuyez sur <i>ctrl</i> ou <i>\u2318</i> + <i>C</i> pour copier les données du tableau à votre presse-papiers. <br><br>Pour annuler, cliquez sur ce message ou appuyez sur Echap.',
			        copySuccess: {
			          _: '%d lignes copiées',
			          1: '1 ligne copiée'
			        }
			      }
			    ],
				"lengthMenu":
					[[20], [ "20"]],
				
				 "language": {
				"url": "../assets/js/Spanish.json"
				 }
			});
		});
	</script>
		<div class="table-responsive">
			<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>#</th>
						<th>Codigo del producto</th>
						<th>Descripcion</th>
						<th>Cantidad</th>
					</tr>
				</thead>
				<body>
					<?php
						$n=1; 
					while($row = mysqli_fetch_array($exQry))
					{
					?>
						<tr>
							<td>
								<?php echo "$n"; ?>
							</td>

							<td align="center">
								<?php echo "$row[0]"; ?>
							</td>
							<td align="center" width="60%">
								<?php echo "$row[1]"; ?>
							</td>
							<td align="center" width="5%">
								<input type="text" class="form-control" onchange="javascript:editar_cantidad($(this).val(), <?php echo $row[2] ?>)" name="" value="<?php echo $row[5] ?>">
							</td>

						</tr>
					
						<?php
					$n++;
				}
					?>
			</table>
		</div>
		</body>
