<form action="" method="POST" id="formDatos3">
<div class="modal fade" id="modal-archivos">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Adjuntar archivo</h4>
      </div>
      <div class="modal-body">
          <label for="documento">*Documento</label>
          <input type="hidden" id="id_equipoS" name="id_equipoS">
          <input name="actionS" type="hidden" value="upload" id="actionS" />
          <input type="file" name="archivosS" id="archivosS">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-danger">Guardar archivo</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
</form>