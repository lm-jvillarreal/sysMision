<div class="modal fade" id="modal-mKAR001" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button style="float: right;" type="button" class="btn btn-secondary" data-dismiss="modal">x</button>
				<div>
					<h4 class="modal-title" id="exampleModalLabel">Kardex | Reporte</h4>
				</div>
			</div>
			<div class="modal-body" style="max-height: calc(200vh - 110px); overflow-y: auto;">
				<form method="POST" id="KAR001">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Fecha Inicial</label>
                                <input type="date" class="form-control" name="fecha_inicial" id="fecha_inicial">                  
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Fecha Final</label>
                                <input type="date" class="form-control" name="fecha_final" id="fecha_final" >                  
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Sucursal</label>
                                <select name="sucursal_KAR001" id="sucursal_KAR001" class="form-control">
                                    <option value=""></option>
                                    <option value="1">Diaz Ordaz</option>
                                    <option value="2">Arboledas</option>
                                    <option value="3">Villegas</option>
                                    <option value="4">Allende</option>
                                </select>                            
                            </div>
                        </div>                        
                    </div>
					<div class=" text-right">
						<button type="button" class="btn btn-danger" id="btn_KAR001" onclick="generarReporte(this)">Descargar Reporte</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>