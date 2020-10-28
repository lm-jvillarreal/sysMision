<div class="modal fade" id="modal-default">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Programación de Actividad: <b><span id="nombre_actividad_modal"></span></b></h4>
            <!-- <button onclick="limpiar()" type="button">Funcion</button> -->
        </div>
        <div class="modal-body">
            <form method="POST" id="form_datos_modal">
                <input type="hidden" id="id_actividad" name="id_actividad">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-4">
                            <label>*Fecha Inicio</label>
                            <div class='input-group date' id='datetimepicker_inicio'>
                              <input type='text' readonly class="form-control" id="fecha_inicio" name="fecha_inicio" value="<?php echo $fecha ?>"/>
                              <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                              <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                            </div>
                        </div>
                        <div class="col-md-4" id="fecha_final">
                            <label>*Fecha Final</label>
                            <div class='input-group date' id='datetimepicker_fin'>
                              <input type='text' readonly class="form-control" id="fecha_fin" name="fecha_fin" value="<?php echo $fecha ?>"/>
                              <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                              <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="">*Repetir</label>
                            <button class="btn btn-danger form-control" type="button" onclick="cambiar()" id="boton_cambiar"><i class="fa fa-ban" aria-hidden="true" id="icono_boton"></i> <span id="texto_cambiar">No Repetir</span></button>
                            <input type="hidden" id="repetir" name="repetir" value="0" class="form-control">
                        </div>
                    </div>
                </div>
                <br>
                <div id="otro" style="display: none;">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <label for="">*Se Repite</label>
                                <select name="repite" id="repite" class="form-control combo2" style="width: 100%">
                                    <option value="1">Todos los dias</option>
                                    <option value="2">Cada Semana</option>
                                    <option value="3">Cada Quincena</option>
                                    <option value="4">Cada Mes</option>
                                    <option value="5">Cada Año</option>
                                </select>
                            </div>
                            <div class="col-md-4" style="display: none;" id="dias">
                                <label for="">*Dias</label><br>
                                <button class="btn btn-sm dias" type="button" value="l">L</button>
                                <button class="btn btn-sm dias" type="button" value="m">M</button>
                                <button class="btn btn-sm dias" type="button" value="x">X</button>
                                <button class="btn btn-sm dias" type="button" value="j">J</button>
                                <button class="btn btn-sm dias" type="button" value="v">V</button>
                                <button class="btn btn-sm dias" type="button" value="s">S</button>
                                <button class="btn btn-sm dias" type="button" value="d">D</button>
                                <input type="hidden" id="dias_selecionados" name="dias_selecionados" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label for="">*Duracion de Actividad</label>
                                <select name="duracion" id="duracion" class="form-control combo2" style="width: 100%">
                                    <option value="1">15 Minutos</option>
                                    <option value="2">30 Minutos</option>
                                    <option value="3">45 Minutos</option>
                                    <option value="4">1 Hora</option>
                                    <option value="5">Todo el Día</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="">*Finaliza</label><br>
                                <input type="hidden" id="finaliza" name="finaliza" value="0" class="form-control">
                                <div class="input-group">
                                  <span class="input-group-btn">
                                    <button class="btn btn-danger btn-md" type="button" onclick="finaliza()" id="boton_finaliza"><i class="fa fa-ban" aria-hidden="true" id="icono_finaliza"></i> <span id="texto_finaliza">Nunca</span></button>
                                  </span>
                                  <div class="input-group date form_date" data-date="<?php echo $fecha ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_llegada" data-link-format="yyyy-mm-dd" style="display: none;" id="fecha_finaliza">
                                    <input class="form-control" size="16" type="text" value="<?php echo $fecha ?>" readonly name="fecha_final2" id="fecha_final2">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                                </div><!-- /input-group -->
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-danger pull-left" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-warning pull-right" id="programar">Programar</button>
        </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->