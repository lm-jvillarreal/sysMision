<div class="modal fade" id="modal-default">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Enviar a:  <label id="nom_persona"></label></h4>
      </div>
      <div class="modal-body">
          <label for="documento">*Elige una opción:</label> <br> 
          <center>
                      <div class="form-group">
                      <select name="compras" id="compras" class="form-control" style="width: 250px">
                        <option value=""></option>
                        <option value="CW">Carlos Weinmann</option>
                        <option value="FR">Francisco Rodríguez</option>
                        <option value="AR">Alejandro Ramírez</option>
                        <option value="JB">Jesús Hernández</option>
                        <option value="JR">Juventino Reyna</option>
                        <option value="JV">Josué Villarreal</option>
                        <option value="EA">Erick Acosta</option>
                        <option value="GP">Gilberto Pineda</option>
                        <option value="GC">Gloria Charur</option>
                      </select>
                      <!-- <select id="compras" name="compras[]" multiple class="select" style="width:100%"></select> -->
                        <!-- <select id="compras" name="compras[]" multiple class="select" style="width:100%"></select> -->
                      </div>
                    
             </center>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-right" id="btn-pagar">Aceptar</button>
        <!-- onclick="insertar();" -->
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->