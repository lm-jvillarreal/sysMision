<div class="modal fade" id="modal-vacaciones">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Vacaciones Promotor</h4>
        </div>
        <div class="modal-body">
            <div id="form_vacaciones">
                <form action="" method="POST" id="form_datos_vacaciones">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                            <label for="">*Nombre Promotor:</label>
                                <input type="hidden" id="id_promotor_vacaciones" name="id_promotor_vacaciones">
                                <input type="hidden" id="fecha1" name="fecha1">
                                <input type="hidden" id="fecha2" name="fecha2">
                                <br>
                                <span id='nombre_promotor_vaca'></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                            <label for="fecha_cambio">*Rango Vacaciones:</label>
                                <div class="input-group">
                                  <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                  </div>
                                  <input type="text" class="form-control pull-right" id="rango_vacaciones" name="rango_vacaciones">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger pull-right" id="guardar_vaca">Guardar</button>
        </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->