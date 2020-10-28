<?php
		//include 'conexion_servidor.php';
		include '../global_settings/conexion.php';
		date_default_timezone_set('America/Monterrey');

      	$sql = "SELECT
					numero_nota,
					orden_compra,
					numero_factura,
					proveedor,
					IFNULL(total,0),
					carta_faltante.id,
					IFNULL(carta_faltante.total_diferencia, 0) AS carta_faltante 
				FROM
					libro_diario
					INNER JOIN proveedores ON proveedores.id = libro_diario.id_proveedor 
					INNER JOIN carta_faltante ON carta_faltante.id_orden = libro_diario.orden_compra
				WHERE
					sucursal = 1 
					AND libro_diario.fecha = CURRENT_DATE";
      	$exSql = mysqli_query($conexion, $sql);


 ?>

	<div class="table-responsive">
	    <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
	      <thead>
	        <tr>
	          <th>Ficha entrada</th>
        	  <th>Folio Infofin</th>	
	          <th>Proveedor</th>
	          <th>Total entrada</th>
	          <th>Total Factura</th>
	          <th>Carta</th>
	          <th>Dif Costos</th>
	          <th>Dif General</th>
	          <th>Folio 2 Infofin</th>
	          <th>Folio 3 Infofin</th>
	          <th>Folio 1 Infofin Dev.</th>
	          <th>Folio 2 Infofin Dev.</th>
	          <th>Comentarios</th>
	          <th>Gran total</th>
	          <th>Revision</th>
	          <th>Diferencia</th>
	        </tr>
	      </thead>
	      <body>
	        <?php
	        	$n = 1;
	        	while ($row = mysqli_fetch_row($exSql)) {?>
	        		<tr>
	        			<td align="center"><?php echo $row[0] ?></td>
	        			<td><a id="aFolio<? echo $n ?>" href="#" onclick="javascript:modal_folio(<?php echo $n ?>)">Folio</a></td>
	        			<!-- <td><input type="text" onchange="javascript:consultar_datos($(this).val())" name="folio_infofin" class="form-control"></td> -->
	        			<td id="tdProveedor">
	        				<?php echo $row[3] ?>
	        			</td>
	        			<td align="center" id="tdTotalEntrada<? echo $n?>">
	        			</td>
	        			<td id="tdTotalFactura<? echo $n ?>">
	        				<?php echo $row[4] ?>
	        			</td>
	        			<td id="tdCarta<? echo $n ?>"><?php echo $row[6] ?></td>
	        			<td id="tdDifCostos<? echo $n ?>"></td>
	        			<td><a id="aDiferenciaGral<? echo $n ?>" href="javascript:modal_dif_gral(<?php echo $n ?>)">0</a></td>
	        			<td id="tdFolioDos<? echo $n ?>">0</td>
	        			<td></td>
	        			<td id="tdDevolucion<? echo $n ?>"><a href="#" onclick="javascript:modal_devoluciones(<?php echo $n ?>)">0</a></td>
	        			<td id="tdDevolucionDos<? echo $n ?>">0</td>
	        			<td></td>
	        			<td id="tdGranTotal<? echo $n ?>"></td>
	        			<td></td>
	        			<td id="tdDiferencia<? echo $n ?>"></td>
	        		</tr>
	        	<?
	        		$n = $n + 1;
	        	}
	        ?>
	    </table>
	</div>
</body>
