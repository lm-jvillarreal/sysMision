<div class="modal fade" id="modal-ArticulosProvedor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button style="float: right;" type="button" class="btn btn-secondary" data-dismiss="modal">x</button>
                <div>
                    <h4 class="modal-title" id="exampleModalLabel">Reportes | Lista de Articulos por proveedor</h4>
                </div>
            </div>
            <div class="modal-body" style="max-height: calc(200vh - 110px); overflow-y: auto;">
                <form method="POST" id="COM004">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="proveedor_COM004">*Proveedor:</label>
                                <select  name="proveedor_COM004" id="proveedor_COM004" class="form-control select2">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                    <button type="button" class="btn btn-danger" id="btn_COM004" onclick="generarReporte(this)">Descargar Reporte</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>