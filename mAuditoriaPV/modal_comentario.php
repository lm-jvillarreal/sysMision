<div class="modal fade" id="modal-default">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Registrar Comentario</h4>
      </div>
      <div class="modal-body">
        <form action="" method="POST" id="form-comentario">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <input type="hidden" name="id_codigo" id="id_codigo">
              <label for="">*Comentario</label>
              <textarea name="observacion" id="observacion" cols="1" rows="3" class="form-control">
              </textarea>
            </div>
          </div>
        </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-right" id="btn-comentario">Guardar Comentario</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->