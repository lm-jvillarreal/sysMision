<?php
		include '../global_settings/conexion.php';
		session_name("login_supsys"); 
		session_start(); 
		$id_mapeo = $_POST['id_mapeo'];
		$qry = "SELECT 
					A.Id, 
					IdDetalleMapeo, 
					IdCaptura, 
					CantidadAnterior, 
					CantidadNueva,
					D.codigo_producto,
					D.descripcion,
					D.id_mapeo,
					M.fecha_conteo,
					S.nombre
				FROM AuditoriaConteo A
				INNER JOIN inv_detalle_mapeo D ON D.id = A.IdDetalleMapeo
				INNER JOIN inv_captura C ON C.id_detalle_mapeo = A.IdDetalleMapeo AND A.IdCaptura = C.id
				INNER JOIN inv_mapeo M ON M.id = D.id_mapeo
				INNER JOIN sucursales S ON S.id = M.id_sucursal
				WHERE A.Estatus = 1";
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
						<th>Folio Mapeo</th>
						<th>Codigo</th>
                    	<th>Descripcion</th>
                    	<th>Conteo</th>
                    	<th>Auditor</th>
                    	<th>Guardar</th>
					</tr>
				</thead>
				<body>
					<?php
					while($row = mysqli_fetch_array($exQry))
					{
					?>
						<tr>
							<td><?php echo $row[7] ?></td>
							<td>
								<?php echo "$row[5]"; ?>
							</td>
							<td>
								<?php echo "$row[6]"; ?>
							</td>
							<td align="center">
								<?php echo "$row[3]"; ?>
							</td>
							<td align="center" width="60%">
								<?php echo $row[4] ?>
							</td>
							<td>
								<a href="#" class="btn btn-danger" onclick="InsertDetalle('<?php echo $row[5] ?>','<?php echo $row[7] ?>', '<?php echo $row[4] ?>', '<?php echo $row[3] ?>', '<?php echo $row[6] ?>', '<?php echo $row[0] ?>' )">Guardar</a>
							</td>
							
						</tr>
						<?php
					}
					?>
			</table>
		</div>
		</body>
