<div class="modal fade" id="modal-detalle">
  <div class="modal-dialog modal-lg" id="modal_detalle">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Inv-Pro | Calendario Producción </h4>
        <br/>
        <label>Para la semana de:</label>
        <label name="semana" id="semana"></label>
        <br/>
        <label>Ventas a día de hoy:</label>
        <label name="produccion" id="produccion"></label>
      </div>
      <div class="modal-body">

        <form action="" method="POST" id="form-modal">
          <div class="row">
            <div class="col-md-1">
              <div class="form-group">
                <label for="clave_receta">*Código:</label>
                <input type="hidden" name="id_receta" id="id_receta">
                <input type="hidden" name="modal_subreceta" id="modal_subreceta">
                <input type="text" name="clave_receta" id="clave_receta" class="form-control" readonly>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="receta">*Tipo:</label>
                <input type="text" name="tipo" id="tipo" class="form-control" readonly>
              </div>
            </div>
          </div>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <div class="row">
            <div class="col-md-2">
              <div class="form-group">
                <label for="receta">*Lunes:</label>
                <input type="number" name="prod_lunes" id="prod_lunes" class="form-control">
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label for="receta">*Martes:</label>
                <input type="number" name="prod_martes" id="prod_martes" class="form-control">
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label for="receta">*Miércoles:</label>
                <input type="number" name="prod_miercoles" id="prod_miercoles" class="form-control">
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label for="receta">*Jueves:</label>
                <input type="number" name="prod_jueves" id="prod_jueves" class="form-control">
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label for="receta">*Viernes:</label>
                <input type="number" name="prod_viernes" id="prod_viernes" class="form-control">
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label for="receta">*Sábado:</label>
                <input type="number" name="prod_sabado" id="prod_sabado" class="form-control">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-2">
              <div class="form-group">
                <label for="receta">*Domingo:</label>
                <input type="number" name="prod_domingo" id="prod_domingo" class="form-control">
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
        <button name="btn-alta" id="btn-alta" type="button" class="btn btn-success pull-right" data-dismiss="modal">Agregar</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->