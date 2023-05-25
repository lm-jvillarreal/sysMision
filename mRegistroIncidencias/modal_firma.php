<div class="modal fade" id="modal-default">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Incidencia de:  <label id="nombreE"></label>
      </div>
      <div class="modal-body">
        <p id="documento"></p>
        <br> 
        <center>
          <div class="col-md-3"><input type="text" id="clave1" ></div>  <br>      
        </center> 
        <div class="col-md-3"><input type="hidden" id="clave"></div>
        
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-success pull-left" id="btn-insertar" onclick="insertarSf();">Insertar sin Firma</button>
        <button type="button" class="btn btn-success pull-center" id="btn-ayuda" onclick="ayuda();">Ayuda</button>
        <button type="button" class="btn btn-danger pull-right" id="btn-autorizar" onclick="validar();" >Aceptar</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->