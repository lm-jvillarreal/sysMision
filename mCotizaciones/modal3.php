<div class="modal fade" id="modal-default3">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Conceptos de Cotización:</h4>
        </div>
        <div class="modal-body">
            <form method="POST" id="form_datos_conceptos">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Concepto:</label>
                                <input type="text" name="concepto" id="concepto" class="form-control" placeholder="Nombre del Concepto">
                                <input type="hidden" name="id_cotizacion_conceptos" id="id_cotizacion_conceptos" class="form-control">
                                <input type="hidden" name="id_concepto" id="id_concepto" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12" id="tabla">
                        <div class="table-responsive">
                          <table id="lista_conceptos" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                              <tr>
                                <th whidth="5%">#</th>
                                <th>Nombre</th>
                                <th whidth="5%">Editar</th>
                                <th whidth="5%">Eliminar</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                              </tr>
                            </tbody>  
                          </table>
                        </div>
                      </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-warning pull-left" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-danger pull-right" id="btn_guardar_concepto">Guardar Concepto</button>
        </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->