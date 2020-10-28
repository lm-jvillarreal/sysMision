<div class="modal fade" id="modal-default2">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Encuesta: <label id="modal_encuesta_e"></label></h4>
        <h5 class="">Trabajador: <label id="modal_encuesta_t"></label></h5>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <form id='form_encuesta' method="POST">
              <input type="hidden" name="id_encuesta_modal" id="id_encuesta_modal">
              <input type="hidden" name="id_encuesta_trabajador" id="id_encuesta_trabajador">
              <table class="table table-striped table-bordered" cellspacing="0" width="100%" id="encuesta">
                <thead>
                  <tr>
                    <th width="5%">#</th>
                    <th>Pregunta</th>
                    <th>Respuesta</th>
                  </tr>
                </thead>
              </table>
            </form>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-danger pull-right" id="btn-guardar" onclick="guardar_resultado()">Guardar Datos</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->