<div class="modal fade" id="modal-coincidencias">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Cartas Faltantes | Lista de coincidencias</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-3">
            <div class="form-group">
              <label for="fecha_inicial_modal">*Fecha de inicio:</label>
              <div class="input-group date form_date" data-date="<?php echo $fecha ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_inicial_modal" data-link-format="yyyy-mm-dd">
                <input class="form-control" size="16" type="text" value="<?php echo $fecha ?>" readonly id="fecha_inicial_modal" name="fecha_inicial_modal">
                <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="fecha_final_modal">*Fecha final:</label>
              <div class="input-group date form_date" data-date="<?php echo $fecha ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_final_modal" data-link-format="yyyy-mm-dd">
                <input class="form-control" size="16" type="text" value="<?php echo $fecha ?>" readonly id="fecha_final_modal" name="fecha_final_modal">
                <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="descripcion">*Descripción:</label>
              <input type="text" name="modal_descripcion" id="modal_descripcion" class="form-control">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table id="lista_articulos" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th width='10%'>C.F.</th>
                    <th width='10%'>Entrada</th>
                    <th width='5%'>Cant.</th>
                    <th>Descripción</th>
                    <th width='10%'>C.U.</th>
                    <th width='10%'>Total</th>
                    <th width='10%'>Fecha</th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->