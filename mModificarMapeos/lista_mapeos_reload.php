<script>
	$(document).ready(function() {
		cargar_tabla()
		});

</script>
<script type="text/javascript">
	function cargar_tabla() {
      $('#lista_mapeos_dos').dataTable().fnDestroy();
      $('#lista_mapeos_dos thead th').each(function() {
        var title = $(this).text();
        $(this).html('<input type="text" placeholder="' + title + '" style="width:100%" />');
      });
      $('#lista_mapeos').dataTable().fnDestroy();
      var table = $('#lista_mapeos').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": false,
        select: {
          style: 'multi'
        },
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
            title: 'FaltantesComprador',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'pdf',
            text: 'Exportar a PDF',
            className: 'btn btn-default',
            title: 'CostosCero',
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
          },
        ]
      });
      table.columns().every(function() {
        var that = this;
        $('input', this.header()).on('keyup change', function() {
          if (that.search() !== this.value) {
            that
              .search(this.value)
              .draw();
          }
        });
      });
    }
</script>
<?php
	
	include '../global_seguridad/verificar_sesion.php';
    //include '../global_settings/conexion_pruebas.php';
	// $pId_sucursal = $_POST['id_sucursal'];
	// $sucursal = $_SESSION["s_Sucursal"];
	// $s_idPerfil = $_SESSION["sTipoUsuario"];
	$pId_sucursal = "1";
	if ($pId_sucursal == "") {
		$qry = "SELECT
					mapeo.id,
					mapeo.zona,
					mapeo.mueble,
					mapeo.cara,
					mapeo.fecha,
					mapeo.id_sucursal,
					areas.nombre
				FROM
					inv_mapeo mapeo 
				INNER JOIN areas ON areas.id = mapeo.id_area
				WHERE 
					mapeo.completo = 1
				AND mapeo.id_sucursal = '$id_sede'
				
				";
		
	}else{
		$qry = "SELECT
					mapeo.id,
					mapeo.zona,
					mapeo.mueble,
					mapeo.cara,
					mapeo.fecha,
					mapeo.id_sucursal,
					areas.nombre
				FROM
					inv_mapeo mapeo
				INNER JOIN areas ON areas.id = mapeo.id_area
				WHERE 
					mapeo.completo = 1
				AND mapeo.id_sede = '$id_sede'
				
				";
	}
	//echo "$qry";
	$consulta = mysqli_query($conexion, $qry);
 ?>
	<div class="table-responsive">
		<table id="lista_mapeos_dos" class="table table-striped table-bordered" cellspacing="0" width="100%">
	        <thead>
	            <tr>
	            	<th>Area</th>
	                <th>Zona</th>
	                <th>Mueble</th>
					<th>Cara</th>
					<th>Fecha</th>
					<th>Continuar</th>
					<th>Eliminar</th>
	            </tr>
	        </thead>
	        <tbody>
	        <?php
	        	while($row = mysqli_fetch_array($consulta))
				{	?>
					<tr>
						<td>
							<?php echo $row[6] ?>
						</td>
						<td>
						<center>
							<?php echo $row[1]; ?>
            			</center>
						</td>
						<td>
							<?php echo "$row[2]"; ?>
						</td>
						<td>
							<?php echo "$row[3]"; ?>
						</td>
						<td>
							<?php echo "$row[4]"; ?>
						</td>
						<td align="center" width="5%">
							<a href="javascript:editar(<?php echo"$row[0]"; ?>, '<?php echo"$row[1]"; ?>', '<?php echo"$row[2]" ?>', '<?php echo"$row[3]" ?>');" onclick="javascript:estante_consecutivo(<?php echo $row[0] ?>)">
								<i class="fa fa-exclamation fa-2x color-icono" aria-hidden="true">
								</i>
							</a>
						</td>
						<td align="center" width="5%">
							<a href="#" onclick="javascript:eliminar_prelistado(<?php echo $row[0] ?>)">
								<i class="fa fa-trash fa-2x color-icono" aria-hidden="true">
								</i>
							</a>
						</td>
						
					</tr>
				<?php
				}
				 ?>
	        </tbody>
		</table>
