<?php
		include '../global_settings/conexion.php';
		session_name("login_supsys"); 
		session_start(); 
		$id_mapeo = $_POST['id_mapeo'];
		$qry = "SELECT 
					D.codigo_producto, 
					D.descripcion, 
					C.cantidad,
					D.Id,
					C.Id,
					D.estante,
					D.consecutivo_mueble
				FROM inv_detalle_mapeo D
				INNER JOIN inv_captura C ON D.id = C.id_detalle_mapeo
				INNER JOIN inv_mapeo M ON M.id = D.id_mapeo
				AND D.id_mapeo = C.id_mapeo
				where D.id_mapeo = '$id_mapeo'
				GROUP BY D.id 
              	ORDER BY D.estante, D.consecutivo_mueble";
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
					[[-1], [ "All"]],
				
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
						<th>Nivel</th>
						<th>Consecutivo</th>
						<th>Codigo</th>
                    	<th>Descripcion</th>
                    	<th>Conteo</th>
                    	<th>Auditor</th>
					</tr>
				</thead>
				<body>
					<?php
					while($row = mysqli_fetch_array($exQry))
					{
					?>
						<tr>
							<td><?php echo "$row[5]" ?></td>
							<td><?php echo "$row[6]" ?></td>
							<td>
								<?php echo "$row[0]"; ?>
							</td>
							<td>
								<?php echo "$row[1]"; ?>
							</td>

							<td align="center">
								<?php echo "$row[2]"; ?>
							</td>
							<td align="center" width="60%">
								<input type="text" class="form-control" onchange="javascript:InsertAuditoria(<?php echo"$row[3]";?>, <?php echo"$row[4]"; ?>, <?php echo"$row[2]"; ?>, $(this).val());" name="">
							</td>
							
						</tr>
						<?php
					}
					?>
			</table>
		</div>
		</body>
