<div class="modal fade" id="modal-default5">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Encuesta de : <label id="n_encuesta_modal"></label></h4>
      </div>
      <div class="modal-body">
        <form id="form-datos" method="POST">
          <div class="row">
            <div class="col-md-12" id="encuesta_preguntas">
              
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-warning pull-right" onclick="guardar_respuesta()">Enviar Encuesta</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->