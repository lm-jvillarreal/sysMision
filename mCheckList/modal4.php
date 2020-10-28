<div class="modal fade" id="modal-default4">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Programacion Multiple de Actividades</h4>
        </div>
        <div class="modal-body">
            <form id="form_datos2" method="POST">
                <input type="hidden" name="id_check_list_modal" id="id_check_list_modal">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-4">
                            <label for="">*Actividad Base</label>
                            <select name="actividad_predeterminada" id="actividad_predeterminada" class="form-control" style="width: 100%"></select>
                        </div>
                        <div class="col-md-4">
                            <label for="">*Tipo</label>
                            <button type="button" class="btn btn-success form-control tipo">Todas</button>
                            <input type="hidden" id="tipo" name="tipo" value="1">
                        </div>
                        <div class="col-md-4" id="div2" style="display: none;">
                            <label for="">*Actividades</label>
                            <select name="actividades[]" id="actividades" class="form-control" style="width: 100%" multiple></select>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-warning pull-right" id="guardar_prog">Guardar</button>
        </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->