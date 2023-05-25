<div class="modal fade" id="modal-firmar">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Incidencia de:  <label id="NombrePers"></label>
        <div class="col-md-3"><input type="hidden" id="registro" ></div>  <br>
      </div>
      <div class="modal-body">
        <p id="documentoFirma"></p>
        <br> 
        <center>
          <div class="col-md-3"><input type="text" id="claveFirma" ></div>  <br>      
        </center> 
        <div class="col-md-3"><input type="hidden" id="confclave"></div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success pull-center" id="btn-ayuda" onclick="ayuda();">Ayuda</button>
        <button type="button" class="btn btn-danger pull-right" id="btn-Editar" onclick="validarFirma()">Aceptar</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->