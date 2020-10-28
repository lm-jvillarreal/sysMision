<div class="modal fade" id="modal-cambio">
  <div class="modal-dialog modal-lg" id="modal_cambio">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Vale Provisional de Caja | Detalle del Cambio</h4>
      </div>
      <div class="modal-body">
        <form action="" method="POST" id="form-detalle">
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label for="folio">Ticket</label>
                <input type="text" name="folio" id="folio" class="form-control" readonly='true'>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label for="folio">Sucursal</label>
                <input type="text" name="m_sucursal" id="m_sucursal" class="form-control" readonly='true'>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="folio">Total</label>
                <input type="text" name="m_total" id="m_total" class="form-control" readonly='true'>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="folio">Cajero(a)</label>
                <input type="text" name="m_cajero" id="m_cajero" class="form-control" readonly='true'>
                <input type="hidden" name="m_idCajero" id="m_idCajero">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label for="artc_articulo">Código</label>
                <input type="text" name="m_codigo" id="m_codigo" class="form-control" readonly="true">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="artc_descripcion">Descripción</label>
                <input type="hidden" name="m_familia" id="m_familia">
                <input type="text" name="m_artc_descripcion" id="m_artc_descripcion" class="form-control" readonly="true">
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label for="precio">*P. Público</label>
                <input type="hidden" name="m_cantidad" id="m_cantidad">
                <input type="text" name="m_precio" id="m_precio" class="form-control" readonly="true">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="cambio">*P. Cambio</label>
                <input type="text" name="m_cambio" id="m_cambio" class="form-control">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="nombre_cliente">*Cliente</label>
                <input type="text" name="m_nombre_cliente" id="m_nombre_cliente" class="form-control">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="m_autoriza">*Autoriza</label>
                <select name="m_autoriza" id="m_autoriza" class="form-control">
                  <option value=""></option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="comentario">*Comentario</label>
                <textarea name="comentario" id="comentario" cols="30" rows="5" class="form-control"></textarea>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-danger pull-right" id="btnCambio">Guardar Cambio</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->