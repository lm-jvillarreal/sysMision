<div class="modal fade" id="modal-default">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Actualizar Terminal - Reporte # <label id="n_reporte"></label></h4>
      </div>
      <div class="modal-body">
        <form action="" method="POST" id="form-datos-act">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="fecha_cambio">*Fecha de cambio:</label>
              <div class="input-group date form_date" data-date="<?php echo $fecha ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_cambio" data-link-format="yyyy-mm-dd">
                <input class="form-control" size="16" type="text" value="<?php echo $fecha ?>" readonly id="fecha_cambio" name="fecha_cambio">
                <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="terminal">Datos Caja</label>
              <input type="text" name="id_historico" id="id_historico" class="hidden">
                <input type="text" name="d_caja" id="d_caja" class="form-control" readonly>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="terminal">*Marca</label>
                <select id="marca_m" style="width: 100%" name="marca_m">
                  <option></option>
                </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="documento">*Modelo</label>
              <select name="modelo_m" id="modelo_m" style="width: 100%"></select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="">*Nuevo Número Serie</label>
              <input type="text" name="numero_serie_m" id="numero_serie_m" class="form-control">
            </div>
          </div>
        </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-right" id="btn-actualizar">Actualizar Caja</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->