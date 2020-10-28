<form action="" method="POST" id="formDatos2">
<div class="modal fade" id="modal-imagenes">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Detalle de Movimiento</h4>
      </div>
      <div class="modal-body">
          <label for="documento">*Documento</label>
          <input type="hidden" id="id_equipo" name="id_equipo">
          <input name="action" type="hidden" value="upload" id="action" />
          <input type="file" name="archivos" id="archivos">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-danger">Guardar Imagen</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
</form>