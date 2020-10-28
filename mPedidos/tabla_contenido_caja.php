<?php
		//include 'conexion_servidor.php';
		include '../global_settings/conexion_supsys.php';
		session_name("login_supsys"); 
		session_start(); 
		date_default_timezone_set('America/Monterrey');

		$id_caja = $_POST['id_caja'];

      	$sql = "SELECT
					id,
					cantidad,
					codigo,
					descripcion,
					id_caja
				FROM
					articulos_cajas 
				WHERE
					id_caja = '$id_caja'";
      	$exSql = mysqli_query($conexion, $sql);


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
	          <th>Codigo</th>
        	  <th>Articulo</th>	
	          <th>Cantidad</th>
	          <th>Eliminar</th>
	        </tr>
	      </thead>
	      <body>
	        <?php
	        	while ($row = mysqli_fetch_row($exSql)) {?>
	        		<tr>
	        			<td align="center"><?php echo $row[2] ?></td>
	        			<td><?php echo $row[3] ?></td>
	        			<td>
	        				<input type="text" class="form-control" onchange="javascript:actualizar($(this).val(), <?php echo $row[0] ?>)" value="<?php echo $row[1] ?>">
	        			</td>
	        			<td align="center">
	        				<a onclick="javascript:quitar_registro(<?php echo $row[0] ?>, <?php echo $row[4] ?>)" href="#" class="fa fa-trash color-icono fa-2x"></a>
	        			</td>
	        		</tr>
	        	<?}
	        ?>
	    </table>
	</div>
</body>
