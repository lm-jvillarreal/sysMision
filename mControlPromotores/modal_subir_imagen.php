<!-- Modal -->
<div id="modalSubir" class="modal fade" role="dialog">
  <div class="modal-dialog modal-md">
    <!-- Modal content-->
    <form id="frmSubir">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Selecciona la fotografía del promotor</h4>
      </div>
      <div class="modal-body">
		<div class="form-group">
			<!-- <label for="image">Nueva imagen</label> -->
	        <input type="file" class="form-control-file" name="image" id="image">
	        <input type="hidden" class="form-control-file" name="id_promotor_modal_subir" id="id_promotor_modal_subir">
	    </div>
      </div>
      <div class="modal-footer">
		<div class="row">
			<div class="col-lg-12">
				<button type="button" id="btnCerrar" class="btn btn-danger  btn-flat  pull-left" data-dismiss="modal">Cerrar</button>
				<input type="button" class="btn btn-warning  btn-flat  pull-right upload" value="Subir Fotografía">
			</div>
		</div>
      </div>
    </div>
	</form>
  </div>
</div>