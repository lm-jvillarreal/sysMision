<div class="modal fade" id="modal-traspaso">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Traspaso de artículos entre tiendas</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" name="ide" id="ide">
        <input type="hidden" name="suc" id="suc">
        <input type="hidden" name="max" id="max">
          <label for="comentario">*Cantidad</label>
          <input type="number" name="cantidad" id="cantidad" class="form-control">
      </div>
      <div class="modal-footer">
        <button class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
        <button class="btn btn-danger pull-right" id="btn-traspasar">Generar traspaso</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->