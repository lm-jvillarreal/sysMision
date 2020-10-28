<div class="modal fade" id="modal-personal">
  <div class="modal-dialog" id="modal_articulos">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Surtido de Pedidos | Listado de personal</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="folio">Folio</label>
          <input type="text" name="folio" id="folio" class="form-control" readonly='true'>
        </div>
        <div class="form-group">
          <label for="usuarios">Asignar a:</label>
          <select name="usuarios" id="usuarios" class="form-control">
            <option value=""></option>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-danger pull-right" id="btn_asignar">Asignar</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->