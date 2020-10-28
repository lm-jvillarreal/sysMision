<div class="modal fade" id="modal-codigos">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Detalle de Folio | Codigos</h4>
      </div>
      <div class="modal-body">
        <form action="" method="POST" id="frm_modal">
          <div class="form-group">
            <label for="modc_tipomov">Tipo de movimiento</label>
            <select name="modc_tipomov" id="modc_tipomov" class="form-control">
              <option value=""></option>
              <option value="ENTCOC">ENTCOC</option>
              <option value="ENTSOC">ENTSOC</option>
              <option value="DEVPRO">DEVPRO</option>
              <option value="DEVXCO">DEVXCO</option>
              <option value="DMPROV">DMPROV</option>
            </select>
          </div>
          <div class="form-group">
            <label for="modn_folio">Folio</label>
            <input type="text" name="modn_folio" id="modn_folio" class="form-control" placeholder="Ingresa un folio" style="width: 100%">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-danger pull-right" id="btnGuardarModal">Guardar registro</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->