<div class="modal fade" id="modal-default">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Registrar pago</h4>
      </div>
      <div class="modal-body">
        <form action="" method="POST" id="form-datos-pago">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="fecha_pago">*Fecha de pago:</label>
              <div class="input-group date form_date" data-date="<?php echo $fecha ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_pago" data-link-format="yyyy-mm-dd">
                <input class="form-control" size="16" type="text" value="<?php echo $fecha ?>" readonly id="fecha_pago" name="fecha_pago">
                <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="tipo_pago">Método de Pago</label>
                <select name="tipo_pago" id="tipo_pago" class="form-control">
                  <option value=""></option>
                  <option value="CHEQUE">Cheque</option>
                  <option value="EFECTIVO">Efectivo</option>
                  <option value="DEPOSITO">Depósito</option>
                  <option value="TRANSFERENCIA">Transferencia</option>
                  <option value="SGRAL1">Ajuste Neg. 1-DO</option>
                  <option value="SGRAL2">Ajuste Neg. 2-ARB</option>
                  <option value="SGRAL3">Ajuste Neg. 3-VILL</option>
                  <option value="SGRAL4">Ajuste Neg. 4-ALL</option>
                </select>
              <input type="hidden" name="id_gasto" id="id_gasto">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="no_comprobante">*No. Comprobante</label>
              <input type="text" name="no_comprobante" id="no_comprobante" class="form-control">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="documento">*Documento</label>
              <input name="action" type="hidden" value="upload" id="action" />
              <input type="file" name="archivos" id="archivos">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="">*Comentario</label>
              <textarea name="observacion" id="observacion" cols="1" rows="3" class="form-control">
                <div id="comenta_edita"></div>
              </textarea>
            </div>
          </div>
        </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-right" id="btn-pagar">Guardar pago</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->