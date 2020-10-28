<div class="modal fade" id="modal-default">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <div id="titulo">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-3">
                            <h4 class="modal-title">Promotor:<br><label id="nombre_promotor"></label></h4>
                        </div>
                        <div class="col-md-3">
                            <h4 class="modal-title">Compañia:<br><label id="compañia"></label></h4>
                        </div>
                        <div class="col-md-3">
                            <h4 class="modal-title">Hora Entrada:<br><label id="hora_entrada_modal"></label></h4>
                        </div>
                        <div class="col-md-3">
                            <h4 class="modal-title">Hora Salida:<br><label id="hora_salidas_modal"></label></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-body">
            <div class="row" id="form">
                <div class="col-md-10">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>*Nueva Actividad</label>
                            <input type="hidden" id="id_promotor_modal" name="id_promotor_modal">
                            <input type="text" name="actividad" id="actividad" class="form-control" onchange="insertar_act(this.value, $('#id_promotor_modal').val())">
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <br>
                    <button class="btn btn-danger btn-sm" onclick="mostrar_cajas()"><i class="fa fa-plus"></i> <label for="">Cajas</label></button>
                  </div>
                </div>
            </div>
            <div class="row" id="form2" style="display: none">
                <div class="col-md-12">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>*Cantidad de Cajas</label>
                            <input type="text" name="cajas2" id="cajas2" class="form-control" onkeyup="if(event.keyCode == 13)insertar_cajas(this.value, $('#id_promotor_modal').val());">
                        </div>
                    </div>
                </div>
            </div>
            <form id="form_terminar" method="POST" style="display: none;">
              <div class="row">
                <div class="col-md-12">
                  <input type="hidden" name="id_actividad_modal" id="id_actividad_modal" value="0">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>*Comentario</label>
                        <input type="text" name="comentario" id="comentario" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-6" id="cajas" style="display: none;">
                      <div class="form-group">
                        <label>*# Cajas</label>
                        <input type="number" name="caja" id="caja" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>*Imagen</label>
                        <input type="file" id="documento" name="documento">
                      </div>
                    </div>
                </div>
              </div>
              <div class="box-footer text-right">
                <button type="submit" class="btn btn-danger" id="guardar">Guardar</button>
              </div>
            </form>
            <div class="row">
                <div class="col-md-12">
                    <div>
                        <div class="col-md-12" id="tabla">
                          <div class="table-responsive">
                            <table id="lista_actividades_promotor" class="table table-striped table-bordered" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th width="5%">#</th>
                                  <th width="20%">Actividad</th>
                                  <th >Inicio</th>
                                  <th >Fin</th>
                                  <th >Duracion</th>
                                  <th >Iniciar</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                </tr>
                              </tbody>  
                            </table>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <div id="btn_marca" style="display: none;">
                <button class="btn btn-danger pull-right" id="">Cerrar</button>
                <button type="submit" class="btn btn-danger pull-right" id="btn-terminar">Terminar</button>
            </div>
        </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->