<?php
		include '../global_settings/conexion_oracle.php';
		error_reporting(E_ALL ^ E_NOTICE);
		session_name("login_supsys"); 
		session_start(); 
		date_default_timezone_set('America/Monterrey');
		$fecha = date('Y-m-d');
		$fecha_inicial = $_POST['fecha_inicial'];
      	$fecha_final = $_POST['fecha_final'];
      	$codigo = $_POST['codigo'];
      	$sucursal = $_POST['sucursal'];
      	$sucursal_admin = $_POST['sucursal_admin'];
      	$descripcion = $_POST['descripcion'];

        $qry = "SELECT
					ARTC_ARTICULO,
					ARTC_DESCRIPCION
				FROM
					COM_ARTICULOS
				WHERE
					ARTC_DESCRIPCION NOT LIKE '%NO USAR%'
					AND ARTC_DESCRIPCION NOT LIKE '%***DESCATALOGADO***%'
				and ARTC_DESCRIPCION LIKE '%$descripcion%'";
            $st_detalle = oci_parse($conexion_central, $qry);
            oci_execute($st_detalle);
 ?>
	<script>
		$(document).ready(function() {
			$('#example').dataTable({
				"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
				
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
	          <th>Descripcion</th>
	        </tr>
	      </thead>
	      <body>
	        <?php
	        while($row = oci_fetch_row($st_detalle))
	        {
	        ?>
	          <tr>
	          	<td>
	          		<?php echo $row[0] ?>
	          	</td>
	            <td>
	              <?php echo "$row[1]"; ?>
	            </td>
	          </tr>
	          <?php
	        }
	        ?>
	    </table>
	</div>
</body>
