<?php
		
		include '../global_settings/conexion_supsys.php';
		session_name("sysAdMision"); 
		session_start(); 
		date_default_timezone_set('America/Monterrey');
		$fecha = date('Y-m-d');
		$sucursal = $id_sede;
        $qry = "SELECT
					turno,
					num_prov,
					proveedor,
					fecha,
					hora_comienzo,
					id
				FROM
					turnos
				WHERE
					id_sucursal = '$sucursal'
				AND estatus = 3";
		$exQry = mysqli_query($conexion, $qry);
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
        		<th># de turno</th>	
	          	<th># de prov</th>
	          	<th>Proveedor</th>
	          	<th>Fecha</th>
	          	<th>Hora Comienzo</th>
	          	<th>Liberar</th>
	        </tr>
	      </thead>
	      <body>
	        <?php
	        while($row = mysqli_fetch_row($exQry))
	        {
	        ?>
	          <tr>
	          	<td>
	          		<?php echo $row[0] ?>
	          	</td>
	            <td>
	              <?php echo "$row[1]"; ?>
	            </td>
	            <td>
	              <?php echo $row[2] ?>
	            </td>
	            <td>
	            	<?php echo $row[3] ?>
	            </td>
	            <td>
	              <?php echo "$row[4]"; ?>
	            </td>
	            <td align="center">
	            	<a href="javascript:comenzar(<?php echo $row[5] ?>)"><i class="fas fa-check-square fa-2x color-icono" ></i></a>
	            </td>
	          </tr>
	          <?
	        }
	        ?>
	    </table>
	</div>
</body>
