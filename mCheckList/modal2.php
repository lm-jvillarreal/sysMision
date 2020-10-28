<div class="modal fade" id="modal-default2">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Detalle de Programacion de Actividad:</h4>
            <input type="hidden" name="id_actividad_modal" id="id_actividad_modal">
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-4">
                        <label for="">*Nombre de Check List : </label> <br>
                        <span id="nombre_check"></span>
                    </div>
                    <div class="col-md-4">
                        <label for="">*Nombre de Actividad : </label> <br>
                        <span id="nombre_actividad"></span>
                    </div>
                    <div class="col-md-4">
                        <label for="">*Sub Departamento : </label> <br>
                        <span id="nombre_subdepartamento"></span>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-4">
                        <label for="">*Tipo de Programacion:</label> <br>
                        <span id="t_programacion"></span>
                    </div>
                    <div class="col-md-4">
                        <label for="">*Fecha Inicio:</label> <br>
                        <span id="fecha_inicio_modal"></span>
                    </div>
                    <div class="col-md-4" id="afecha_final">
                        <label for="">*Fecha Final:</label> <br>
                        <span id="fecha_final_modal"></span>
                    </div>
                    <div class="col-md-4" id="arepite" style="display: none;">
                        <label for="">*Se Repite:</label> <br>
                        <span id="se_repite"></span>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-4" style="display: none;" id="dias_selec">
                        <label for="">*Dias Seleccionados:</label> <br>
                        <span id="dias_seleccionados"></span>
                    </div>
                    <div class="col-md-4" style="display: none;" id="duracion_act">
                        <label for="">*Duracion:</label> <br>
                        <span id="duracion_actividad"></span>
                    </div>
                    <div class="col-md-4" style="display: none;" id="finaliza_act">
                        <label for="">*Finaliza:</label> <br>
                        <span id="finaliza_modal"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-warning pull-left" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-danger pull-right" id="eliminar_programacion">Eliminar Programación</button>
        </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->