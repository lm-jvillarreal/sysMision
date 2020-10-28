<?php
		//include 'conexion_servidor.php';
	error_reporting(E_ALL ^ E_NOTICE);
		include '../global_settings/conexion_supsys.php';
		session_name("login_supsys"); 
		session_start(); 
		date_default_timezone_set('America/Monterrey');
		$fecha = date('Y-m-d');
		$sucursal = $id_sede;
        $qry = "SELECT
					turno,
					num_prov,
					proveedor,
					fecha,
					hora,
					id,
					tipo
				FROM
					turnos
				WHERE
					id_sucursal = '$sucursal'
				AND estatus = 1";
				//echo "$qry";
		$exQry = mysqli_query($conexion, $qry);
 ?>
	<script>
		$(document).ready(function() {
			$('#example').dataTable({

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
        		<th># de turno</th>	
	          <th># de prov</th>
	          <th>Proveedor</th>
	          <th>Fecha</th>
	          <th>Hora</th>
	          <th>Imprimir</th>
	          <th>Recibir</th>
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
	        <!--     	<a target="_blank" href="ticket/index.php?id=<?php echo $row[5] ?>&sucursal=<?php echo $sucursal ?>&proveedor=<?php echo $row[2] ?>&tipo=<?php echo $row[6] ?>"><i class="fas fa-print fa-2x color-icono" ></i></a> -->
	            	<a href="#" class="btn btn-danger">Imprimir</a>
	            </td>
	            <td align="center">
	         <!--    	<a href="javascript:recibir(<?php echo $row[5] ?>)"><i class="fas fa-check-square fa-2x color-icono" ></i></a> -->
            		<a href="#" class="btn btn-danger">Recibir</a>
	            </td>
	          </tr>
	          <?
	        }
	        ?>
	    </table>
	</div>
</body>
