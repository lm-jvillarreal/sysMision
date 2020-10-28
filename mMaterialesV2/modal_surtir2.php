<div class="modal fade" id="modal-surtir2">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Surtir Material Personalizado</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <form id="form_surtir" method="POST">
            <div class="col-md-12">
               <div class="table-responsive">
                  <table id="lista_surtir" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Descripción</th>
                        <th>Solicitado</th>
                        <th>Surtir</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th>#</th>
                        <th>Descripción</th>
                        <th>Solicitado</th>
                        <th>Surtir</th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
            </div>
          </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning pull-left" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-danger pull-right" id="guardar_modal" onclick="surtir2()">Surtir</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->