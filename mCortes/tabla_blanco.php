<?php
		include 'conexion_servidor.php';
		session_name("login_supsys"); 
		session_start(); 
		date_default_timezone_set('America/Monterrey');
		$fecha = date('Y-m-d');
		$fecha_inicial = $_POST['fecha_inicial'];
      	$fecha_final = $_POST['fecha_final'];
      	$codigo = $_POST['codigo'];
      	$sucursal = $_POST['sucursal'];
      	$sucursal_admin = $_POST['sucursal_admin'];

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
	          <th>Turno</th>
        	  <th># Proveedor</th>	
	          <th>Proveedor</th>
	          <th>Marcar</th>
	        </tr>
	      </thead>
	      <body>
	        <?php
	        ?>
	    </table>
	</div>
</body>
