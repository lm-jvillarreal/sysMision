<div class="modal fade" id="ModalNuevoPromotor">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Añadir Promotor<br><label id="nombre_promotor"></label></h4>
        </div>
        <div class="modal-body">
          <form id="form_datos_modal" method="POST">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>*Promotor</label>
                  <select name="promotor_m" id="promotor_m" class="form-control" style="width: 100%"></select>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button class="btn btn-warning pull-left" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-danger pull-right" id="btn-terminar" onclick="añadir()">Añadir</button>
        </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->