<div class="modal fade" id="modal-mSIS007" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button style="float: right;" type="button" class="btn btn-secondary" data-dismiss="modal">x</button>
				<div>
					<h4 class="modal-title" id="exampleModalLabel">Grafica | Datalogic</h4>
				</div>
			</div>
			<div class="modal-body" style="max-height: calc(200vh - 110px); overflow-y: auto;">
				<div class="row">
					<div class="col-md-6">
						<label>*Fecha Inicio</label>
						<div class="input-group date form_date" data-date="<?php echo $fecha1_SISI007 ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_llegada" data-link-format="yyyy-mm-dd">
							<input class="form-control" size="16" type="text" value="<?php echo $fecha1_SISI007 ?>" readonly name="fecha1_SISI007" id="fecha1_SISI007">
							<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
							<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
						</div>
					</div>
					<div class="col-md-6">
						<label>*Fecha Final</label>
						<div class="input-group date form_date" data-date="<?php echo $fecha2_SISI007 ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_llegada" data-link-format="yyyy-mm-dd">
							<input class="form-control" size="16" type="text" value="<?php echo $fecha2_SISI007 ?>" readonly name="fecha2_SISI007" id="fecha2_SISI007">
							<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
							<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
						</div>
					</div>
				</div>
				<br>
				<div class="text-right">
					<button class="btn btn-warning" id="guardar" onclick="generar_SISI007()">Generar</button>
				</div>
				<br>
				<div class="row">
					<div class='col-md-12'>
						<div id="grafica"></div>   
					</div>     
				</div>
			</div>
		</div>
	</div>
</div>
