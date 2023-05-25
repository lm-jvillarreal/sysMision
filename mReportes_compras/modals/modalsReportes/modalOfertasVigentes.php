<div class="modal fade" id="modal-OfertasVigentes" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button style="float: right;" type="button" class="btn btn-secondary" data-dismiss="modal">x</button>
                <div>
                    <h4 class="modal-title" id="exampleModalLabel">Reporte | Ofertas Vigentes</h4>
                </div>
            </div>
            <div class="modal-body" style="max-height: calc(200vh - 110px); overflow-y: auto;">
                <form method="POST" id="COM003">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="sucursal_COM003">*Sucursal:</label>
                                <div>
                                    <select name="sucursal_COM003" id="sucursal_COM003" class="form-control select select2">
                                    <option value=""></option>
                                    <option value="1">Díaz Ordaz</option>
                                    <option value="2">Arboledas</option>
                                    <option value="3">Villegas</option>
                                    <option value="4">Allende</option>
                                    <option value="5">Petaca</option>
                                    <option value="6">Montemorelos</option>
                                    <option value="99">CEDIS</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="departamento_COM003">Departamento:</label>
                                <select name="departamento_COM003" class= "form-control select2 no-validar" id="departamento_COM003" required >
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="proveedor_COM003">Proveedor:</label>
                                <select name="proveedor_COM003" id="proveedor_COM003" class="form-control select2 no-validar">
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>                        
                    </div>
                    <div class="text-right">
                        <button type="button" class="btn btn-danger" id="btn_COM003" onclick="generarReporte(this)">Descargar Reporte</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


