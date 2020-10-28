<?php
		include '../global_settings/conexion_supsys.php';
		session_name("login_supsys"); 
		session_start(); 
		date_default_timezone_set('America/Monterrey');
		$fecha = date('Y-m-d');
		$sucursal = $_SESSION["s_Sucursal"];
        $qry = "SELECT
					id,
					codigo,
					descripcion 
				FROM
					cajas_articulos";
		$exQry = mysqli_query($conexion, $qry);
 ?>
	<script>
		$(document).ready(function() {
			$('#example1').dataTable({

				"lengthMenu":
					[[-1], [ "All"]],
				
				 "language": {
				"url": "../assets/js/Spanish.json"
				 }
			});
		});
	</script>
	<div class="table-responsive">
	    <table id="example1" class="table table-striped table-bordered" cellspacing="0" width="100%">
	      <thead>
	        <tr>
    			<th>Codigo Caja</th>	
	          	<th>Descripcion</th>
	          	<th>Editar</th>
	          	<th>Borrar</th>
	        </tr>
	      </thead>
	      <body>
	        <?php
	        while($row = mysqli_fetch_row($exQry))
	        {
	        ?>
	          <tr>
	          	<td align="center">
	          		<?php echo $row[1] ?>
	          	</td>
	            <td align="center">
	              <?php echo "$row[2]"; ?>
	            </td>
	            <td align="center">
	            	<a onclick="javascript:editar_caja(<?php echo $row[0] ?>);" class="fa fa-edit color-icono fa-2x"></a>
	            </td>
	            <td align="center">
	            	<a  onclick="javascript:borrar_caja(<?php echo $row[0] ?>)" class="fa fa-trash color-icono fa-2x"></a>
	            </td>
	          </tr>
	          <?
	        }
	        ?>
	    </table>
	</div>
</body>
