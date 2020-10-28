<div class="modal fade" id="modal-default3">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Asignacion Multiple de Equipos</h4>
        </div>
        <form id="form_datos2" method="POST">
            <div class="modal-body">
                <!-- <input type="hidden" name="id_check_list_modal" id="id_check_list_modal"> -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-4">
                            <label for="">*Caja Base:</label>
                            <select name="caja_modal" id="caja_modal" class="form-control" style="width: 100%"></select>
                        </div>
                        <div class="col-md-4">
                            <label for="">*Tipo:</label>
                            <button type="button" class="btn btn-success form-control tipo">Todas</button>
                            <input type="hidden" id="tipo_modal" name="tipo_modal" value="1">
                        </div>
                        <div class="col-md-4" id="div2" style="display: none;">
                            <label for="">*Sucursal</label>
                            <select name="sucursal_modal" id="sucursal_modal" class="form-control" style="width: 100%"></select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-warning pull-right" id="guardar_var">Guardar</button>
                <!-- <button type="button" class="btn btn-primary pull-right" id="act_var">Actualizar Datos</button> -->
            </div>
        <form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->