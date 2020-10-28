<div class="modal fade" id="modal-default3">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Pregunta: <label id="n_pregunta"></label></h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <!-- <form id='form_encuesta' method="POST"> -->
              <input type="hidden" name="id_pregunta_modal" id="id_pregunta_modal">
              <input type="text" name="respuesta" id="respuesta" class="form-control" onchange="guardar_respuesta(this.value)">
            <!-- </form> -->
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col-md-12" id="tabla">
            <div class="table-responsive">
              <table id="lista_respuestas" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th width="5%">#</th>
                    <th>Respuesta</th>
                    <th width="10%">Eliminar</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th width="5%">#</th>
                    <th>Nombre</th>
                    <th width="10%">Eliminar</th>
                  </tr>
                </tfoot>  
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->