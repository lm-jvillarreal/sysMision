<?php
		//include 'conexion_servidor.php';
		include '../global_settings/conexion_oracle.php';
		session_name("login_supsys"); 
		session_start(); 
		date_default_timezone_set('America/Monterrey');
		$fecha = date('Y-m-d');
		// $sucursal = $_SESSION["s_Sucursal"];
		$cajero = $_POST['cajero'];
		$fecha_inicial = $_POST['fecha_inicial'];
		$fecha_final = $_POST['fecha_final'];
		$fecha_i=str_replace("-","",$fecha_inicial);
		$fecha_f=str_replace("-","",$fecha_final);

		ini_set('max_execution_time', 1000);

		$sql = "SELECT
					TICN_AAAAMMDDVENTA,
					TICN_FOLIO,
					TO_CHAR (
						TICD_FECHAHORAVENTA,
						'YYYY/MM/DD'
					),
					ROUND (TICN_VENTA, 2),
					TICC_MOTIVOCANC,
					(
						SELECT
							CFG_USUARIOS.USUC_NOMBRE
						FROM
							CFG_USUARIOS
						WHERE
							CFG_USUARIOS.USUN_ID = PV_TICKETS.TICN_USUARIOAUTORIZADEV
					)
				FROM
					PV_TICKETS
				WHERE
					TICN_ESTATUS = '4'
				AND TICC_CAJERO = '$cajero'
				AND TICN_AAAAMMDDVENTA BETWEEN '$fecha_i'
				AND '$fecha_f'";
				//echo "$sql";
		$st = oci_parse($conexion_central, $sql);
		oci_execute($st);

        
 ?>

	<script>
		$(document).ready(function() {
			$('#example2 thead th').each( function () {
		        var title = $(this).text();
		        $(this).html( '<input type="text" placeholder="'+title+'" style="width:100%" />' );
		    });
			$('#example2').dataTable().fnDestroy();
			var table = $('#example2').DataTable({
			    'language': {"url": "../plugins/DataTables/Spanish.json"},
			    "paging":   false,
			    "dom": 'Bfrtip',
		        "buttons": [
		            'copy', 'csv', 'excel', 'pdf', 'print'
		        ]
			});
			table.columns().every( function () {
		        var that = this;
		        $( 'input', this.header() ).on( 'keyup change', function () {
		            if ( that.search() !== this.value ) {
		                that
		                    .search( this.value )
		                    .draw();
		            }
		        });
	    	});
		});
	</script>
	<div class="table-responsive">
	    <table id="example2" class="table table-striped table-bordered" cellspacing="0" width="100%">
	      <thead>
	        <tr>
        		<th>AAAAMMDD</th>
        		<th>Folio</th>
	          	<th>Fecha</th>
	          	<th>Cantidad</th>
	          	<th>Causa</th>
	          	<th>Autorizado</th>
	        </tr>
	      </thead>
	      <body>
	        <?php
	        while($row = oci_fetch_row($st))
	        {
	        ?>
	          <tr>
	          	<td>
	          		<?php echo $row[0] ?>
	          	</td>
	          	<td>
	          		<?php echo $row[1] ?>
	          	</td>
	            <td>
	              <?php echo $row[2]; ?>
	            </td>
	            <td>
	              <?php echo $row[3] ?>
	            </td>
	            <td><?php echo $row[4] ?></td>
	            <td>
	            	<?php echo $row[5] ?>
	            </td>
	          </tr>
	          <?
	        }
	        ?>
	    </table>
	</div>
</body>
