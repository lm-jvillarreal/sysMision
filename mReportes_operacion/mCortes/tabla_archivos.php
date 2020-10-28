<?php
		include 'conexion_servidor.php';
		session_name("login_supsys"); 
		session_start(); 
		date_default_timezone_set('America/Monterrey');
		$fecha = date('Y-m-d');
		$sucursal = $_SESSION["s_Sucursal"];
		$s_idUsuario = $_SESSION["s_IdUser"];
		$fecha_final = $_POST['fecha_final'];
		$fecha_inicial = $_POST['fecha_inicial'];
        $qry = "SELECT
					id, titulo, ruta
				FROM
					archivos_manuales";
		$exQry = mysqli_query($conexion_mysql, $qry);

		
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
    			<th>#</th>	
      			<th>Titulo</th>
          		<th>Archivo</th>
	        </tr>
	      </thead>
	      <body>
	        <?php
	        $n =1;
	        while($row = mysqli_fetch_row($exQry))
	        {
	        ?>
	          <tr align="center">
	          	<td>
	          		<?php echo $row[0] ?>
	          	</td>
	            <td align="center">
	              <?php echo "$row[1]"; ?>
	            </td>
	            <td align="center">
	              <a onclick="javascript:insertar_registro(<?php echo $s_idUsuario ?>, <?php echo $row[0] ?>)" href="<?php echo $row[2] ?>"><i class="fas fa-download fa-2x color-icono"></i></a>
	            </td>
	          </tr>
	          <?
	          $n = $n + 1;
	        }
	        ?>
	    </table>
	</div>
</body>
