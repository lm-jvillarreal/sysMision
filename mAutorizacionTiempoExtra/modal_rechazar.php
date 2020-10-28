<div class="modal fade" id="modal-rechazar">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Rechazar Tiempo Extra de: <label id="nombre_personaa"></label></h4>
      </div>
      <div class="modal-body">
        <form action="" method="POST" id="form_datos_rechazar">
        <div class="row">
        <div class="col-md-12">
            <div class="form-group">
              <label for="id_registroo"></label>
              <input type="text" name="id_registroo" id="id_registroo" class="hidden">
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label for="fecha_cambioo">*Horas Disponibles:</label>
              <input type="text" name="horas_disponibless"  id="horas_disponibless" class="form-control" readonly>
              <input type="text" name="id_perss" id="id_perss" class="hidden">
            </div>
          </div>
          </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="terminal">*Comentario</label>
                <input type="text" name="comentarioo" id="comentarioo" class="form-control">
            </div>
          </div>
        </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-right" id="btn-rechazar">Rechazar Tiempo Extra</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->