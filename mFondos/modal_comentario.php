<div class="modal fade" id="modal-comentario">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Editar Comentario</h4>
      </div>
      <div class="modal-body">
        <form action="" method="POST" id="form-comentario">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="comentario">*Comentario</label>
              <input type="hidden" id="id_aportacion" name="id_aportacion">
              <textarea name="area_comentario" id="area_comentario" class="form-control"></textarea>
            </div>
          </div>
        </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-right" id="btn-modifComent">Guardar pago</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->