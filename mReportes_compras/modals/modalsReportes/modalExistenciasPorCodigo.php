<div class="modal fade" id="modal-ExistenciasPorCodigo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button style="float: right;" type="button" class="btn btn-secondary" data-dismiss="modal">x</button>
                <div>
                    <h4 class="modal-title" id="exampleModalLabel">Reportes | Existencias por codigo</h4>
                </div>
            </div>
            <div class="modal-body" style="max-height: calc(200vh - 110px); overflow-y: auto;">
                <form method="POST" id="COM007">
                    <div class="row">
                        <div class="col-lg-3">
                            <label for="sucursal_COM007">*Sucursal:</label>
                            <select class="form-control select" name="sucursal_COM007" id="sucursal_COM007">
                                <option value=""></option>
                                <option value="1">Diaz Ordaz</option>
                                <option value="2">Arboledas</option>
                                <option value="3">Villegas</option>
                                <option value="4">Allende</option>
                                <option value="5">Petaca</option>
                                <option value="6">Montemorelos</option>
                                <option value="99">CEDIS</option>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">Archivo:</label>
                                <input class="form-control no-validar" type="file" name="excel">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <label for="departamento_COM007">Departamento:</label>
                            <select class="form-control select2 no-validar" name="departamento_COM007" id="departamento_COM007">
                                <option></option>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label for="familia_COM007">Familia:</label>
                            <select name="familia_COM007" id="familia_COM007" class="form-control select2 no-validar">
                                <option></option>
                            </select>
                        </div>
                    </div>
                    <!-- <input type="hidden" name="array" class="form-control" id="array_compras_vs"> -->
                    <br>
                    <div class="text-right">
                        <a href="javascript:subir_excel($('#frmDatosComprasVsVentas').attr('id'), $('#array_compras_vs').attr('id'))" class="btn btn-danger">Subir</a>
                        <button type="button" class="btn btn-danger" id="btn_COM007" onclick="generarReporte(this)">Descargar Reporte</button>
                        <a href="#" onclick="mostrar_datos()" class="btn btn-danger">Mostrar tabla</a>
                    </div>
                </form>

                <br>
                <div class="">
                    <div class="box-header">
                        <h3 class="box-title">Registros</h3>
                    </div>
                    <div class="box-body">
                        <div id="contenedor"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>