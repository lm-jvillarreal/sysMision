<div class="modal fade" id="modal-default">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Pagar Horas a <label id="nom_persona"></label></h4>
      </div>
      <div class="modal-body">
        <form action="" method="POST" id="form_datos_pagar">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="fecha_cambio">*Horas Disponibles:</label>
              <input type="text" name="horas_disponibles" id="horas_disponibles" class="form-control" readonly>
              <input type="text" name="horas_disp" id="horas_disp" class="hidden">
              <input type="text" name="id_pers" id="id_pers" class="hidden">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="terminal">*Tiempo a Pagar</label>
              <input type="text" name="h_pagar" id="h_pagar" class="form-control">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="terminal">*Comentario</label>
                <input type="text" name="comentario" id="comentario_modal" class="form-control">
            </div>
          </div>
        </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-right" id="btn-pagar">Pagar Horas</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->