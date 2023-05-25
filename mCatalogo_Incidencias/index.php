<?php
  include '../global_seguridad/verificar_sesion.php';
 ?>
<!DOCTYPE html>
  <html>
    <head>
      <?php include '../head.php'; ?>
    </head>
    <body class="hold-transition skin-red sidebar-mini">
      <div class="wrapper">
        <header class="main-header">
          <?php include '../header.php'; ?>
        </header>
          <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">
          <!-- sidebar: style can be found in sidebar.less -->
          <?php include 'menuV.php'; ?>
          <!-- /.sidebar -->
        </aside>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <!-- Main content -->
          <section class="content">
            <div class="box box-danger">
              <div class="box-header">
                <h3 class="box-title">Catálogos Generales</h3>
              </div>
              <div class="box-body">
                <div class="tabbable">
                  <ul class="nav nav-tabs">
                    <li class="active"><a href="#1" data-toggle="tab" id="clavesAPSI" onclick="ocultar()">Claves APSI</a></li>
                    <li><a href="#2" data-toggle="tab" id="categorias" onclick="ocultar1()">Categorías</a></li>
                    <li><a href="#6" data-toggle="tab" id="tipos" onclick="ocultar5()">Tipos</a></li>
                    <li><a href="#3" data-toggle="tab" id="incidencias" onclick="ocultar2()">Incidencias</a></li>
                    <li><a href="#4" data-toggle="tab" id="gravedades" onclick="ocultar3()"cc>Gravedad de incidencias</a></li>
                    <li><a href="#5" data-toggle="tab" id="acciones" onclick="ocultar4()">Acciones Sugeridas</a></li>
                    
                  </ul>
                  <div class="tab-content">
                    <div class="tab-pane active" id="1">
                      <form method="POST" id="form_datos">
                        <br>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <input type="hidden"name="id_registroo" id="id_registroo">
                              <label>*Clave APSI</label>
                              <div class="input-group">
                                <input type="text" name="claveApsi" id="claveApsi" class="form-control" placeholder="Ejemplo: 109">
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label>*Nombre</label>
                              <div class="input-group">
                                <input type="text" name="nombre" id="nombre"class="form-control" placeholder="Ejemplo: Accidente Laboral" style="width: 250px" >
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="box-footer text-right">
                          <button type="button" class="btn btn-warning" id="guardarApsi" onclick="guardar()">Guardar</button>
                          <button type="button" class="btn btn-danger" id="cancelarApsi" onclick="cancelar()">Cancelar</button>
                        </div>
                      </form>
                    </div>
                    <div class="tab-pane" id="2">
                      <form method="POST" id="cat">
                        <br>
                        <div class="row">
                          <div class="col-md-6">
                            <div>
                              <div class="form-group">
                                <input type="hidden"name="id_registro1" id="id_registro1">
                                <label for="">*Categoría</label>
                                <input type="text" name="categoria" id="categoria" class="form-control"placeholder="Ejemplo: Indisciplina">
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="box-footer text-right">
                          <button type="button" class="btn btn-warning" id="guardarCat" onclick="guardar1()">Guardar
                          </button>
                          <button type="button" class="btn btn-danger" id="cancelarc" onclick="cancelar()">Cancelar</button>
                        </div> 
                      </form>
                    </div>
                    <div class="tab-pane" id="3">
                      <form method="POST" id="form_incidencias">
                        <br>
                        <div class="row">
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="">*Incidencia</label>
                              <input type="hidden" name="id_registro2" id="id_registro2">
                              <input type="text" name="incidencia" id="incidencia" class="form-control" placeholder="Ejemplo: Robo">
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="">*Categoría</label>
                              <select name="categoriaa" id="categoriaa" class="form-control" style="width:230px">
                                <option value="1">Indisciplina</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="">*Tipo</label><br>
                              <select name="tipoIn" id="tipoIn" class="form-control select2" style="width:230px">
                                <option value=""></option>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="">*Gravedad</label>
                              <select name="gravedad" id="gravedad" class="form-control select2" style="width: 230px">
                                <option value=""></option>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="">*Acción Sugerida</label>
                              <select name="accion" id="accion" class="form-control select2" style="width: 230px"></select>
                            </div>
                          </div>
                        </div>
                        <div class="box-footer text-right">
                          <button type="button" class="btn btn-warning" id="guardarIncidencia" onclick="guardar2()">Guardar</button>
                          <button type="button" class="btn btn-danger" id="cancelari" onclick="cancelar()">Cancelar</button>
                        </div>
                      </form>
                    </div>
                    <div class="tab-pane" id="4">
                      <form method="POST" id="form_gravedad">
                        <br>
                        <!-- <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="">*Gravedad</label>
                              <input type="text" name="gravedadI" class="form-control" id="g1" onkeyup="if(event.keyCode ==13 || event.keyCode == 9)siguiente('g',this.value,1)">
                            </div>
                          </div>
                        </div> -->
                        <!-- <div class="box-footer text-right">
                          <button type="submit" class="btn btn-warning" id="guardarGravedad">Guardar</button>
                        </div> -->
                      </form>
                    </div>
                    <div class="tab-pane" id="5">
                      <form method="POST" id="acciones" >
                        <br>
                        <!-- <div class="row" >
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="">*Acción Sugerida</label>
                              <input type="text" name="accionS"class="form-control" id="a1" onkeyup="if(event.keyCode==13||event.keyCode==9)siguiente('a',this.value,1)">
                            </div>
                          </div>
                          </div>
                        <div class="box-footer text-right">
                          <button type="submit" class="btn btn-warning" id="guardarAcciones">Guardar</button>
                        </div> -->
                      </form>
                    </div>
                    <div class="tab-pane" id="6">
                      <form method="POST" id="tipoI">
                        <br>
                        <div class="row">
                          <div class="col-md-3">
                            <div>
                              <div class="form-group">
                                <label for="">*Tipo</label>
                                <input type="hidden" name="id_registro6" id="id_registro6">
                                <input type="text" name="tipo" id="tipo" class="form-control"placeholder="Ejemplo: Código de Vestimenta"style="width:230px">
                              </div>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="">*Categoría</label>
                              <select name="categoriaT" id="categoriaT" class="form-control select2" style="width:230px">
                                <option value="1">Indisciplina</option>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="box-footer text-right">
                          <button type="button" class="btn btn-warning" id="guardartipo" onclick="guardarTipo()">Guardar
                          </button>
                          <button type="button" class="btn btn-danger" id="cancelartipo" onclick="cancelar()">Cancelar</button>
                        </div> 
                      </form>
                    </div>
                  </div> 
                </div>
              </div>
            </div> 
            <div id="APSI">
              <form action="" id="tablaApsi">
                <div class="box box-danger">
                  <div class="box-header">
                    <h3 class="box-title">Lista de Claves APSI</h3>
                  </div>
                  <div class="box-body">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="table-responsive">
                          <table id="lista_claves" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                              <tr>
                                <th width="5%">ID</th>
                                <th width="15%">Clave APSI</th>
                                <th width="15%">Nombre</th>
                                <th width="15%">Usuario</th>
                                <th width="15%">Activo</th>
                              </tr>
                            </thead>
                            <tfoot>
                              <tr>
                                <th width="5%">ID</th>
                                <th width="15%">Clave APSI</th>
                                <th width="15%">Nombre</th>
                                <th width="15%">Usuario</th>
                                <th width="15%">Activo</th>
                              </tr>
                            </tfoot>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </form> 
            </div>
            <div id="categ"style= "display:none">
              <form action="" id="tablaCategoria">
                <div class="box box-danger">
                  <div class="box-header">
                    <h3 class="box-title">Lista de Categorías</h3>
                  </div>
                  <div class="box-body">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="table-responsive">
                          <table id="lista_categorias" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                              <tr>
                                <th width="5%">ID</th>
                                <th width="15%">Categoría</th>
                                <th width="15%">Usuario</th>
                                <th width="15%">Activo</th>
                              </tr>
                            </thead>
                            <tfoot>
                              <tr>
                                <th width="5%">ID</th>
                                <th width="15%">Categoría</th>
                                <th width="15%">Usuario</th>
                                <th width="15%">Activo</th>
                              </tr>
                            </tfoot>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </form> 
            </div>
            <div id="incid"style= "display:none">
              <form action="" id="tablaIncidencias">
                <div class="box box-danger">
                  <div class="box-header">
                    <h3 class="box-title">Lista de Incidencias</h3>
                  </div>
                  <div class="box-body">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="table-responsive">
                          <table id="lista_incidencias" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                              <tr>
                                <th width="5%">ID</th>
                                <th width="15%">Incidencias</th>
                                <th width="15%">Categoría</th>
                                <th width="15%">Tipo</th>
                                <th width="15%">Gravedad</th>
                                <th width="15%">Accion Sugerida</th>
                                <th width="15%">Activo</th>
                              </tr>
                            </thead>
                            <tfoot>
                              <tr>
                                <th width="5%">ID</th>
                                <th width="15%">Incidencias</th>
                                <th width="15%">Categoría</th>
                                <th width="15%">Tipo</th>
                                <th width="15%">Gravedad</th>
                                <th width="15%">Accion Sugerida</th>
                                <th width="15%">Activo</th>
                              </tr>
                            </tfoot>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </form> 
            </div>
            <div id="gravedadIncidencias"style= "display:none">
              <form action="" id="tablaGravedad">
                <div class="box box-danger">
                  <div class="box-header">
                    <h3 class="box-title">Lista de Gravedades (Incidencias)</h3>
                  </div>
                  <div class="box-body">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="table-responsive">
                          <table id="lista_gravedades" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                              <tr>
                                <th width="5%">ID</th>
                                <th width="15%">Gravedad</th>
                                <th width="15%">Usuario</th>
                                <th width="15%">Activo</th>
                              </tr>
                            </thead>
                            <tfoot>
                              <tr>
                                <th width="5%">ID</th>
                                <th width="15%">Gravedad</th>
                                <th width="15%">Usuario</th>
                                <th width="15%">Activo</th>
                              </tr>
                            </tfoot>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </form> 
            </div>
            <div id="accionesSugeridas"style= "display:none">
              <form action="" id="tablaAcciones">
                <div class="box box-danger">
                  <div class="box-header">
                    <h3 class="box-title">Lista de Acciones Sugeridas (Incidencias)</h3>
                  </div>
                  <div class="box-body">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="table-responsive">
                          <table id="lista_acciones" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                              <tr>
                                <th width="5%">ID</th>
                                <th width="15%">Acción sugerida</th>
                                <th width="15%">Usuario</th>
                                <th width="15%">Activo</th>
                              </tr>
                            </thead>
                            <tfoot>
                              <tr>
                                <th width="5%">ID</th>
                                <th width="15%">Acción Sugerida</th>
                                <th width="15%">Usuario</th>
                                <th width="15%">Activo</th>
                              </tr>
                            </tfoot>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </form> 
            </div>
            <div id="tiposI"style= "display:none">
              <form action="" id="tablaTipos">
                <div class="box box-danger">
                  <div class="box-header">
                    <h3 class="box-title">Lista de Tipos de Incidencias</h3>
                  </div>
                  <div class="box-body">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="table-responsive">
                          <table id="lista_tipos" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                              <tr>
                                <th width="5%">ID</th>
                                <th width="15%">Tipo</th>
                                <th width="15%">Categoría</th>
                                <th width="15%">Usuario</th>
                                <th width="15%">Activo</th>
                              </tr>
                            </thead>
                            <tfoot>
                              <tr>
                                <th width="5%">ID</th>
                                <th width="15%">Tipo</th>
                                <th width="15%">Categoría</th>
                                <th width="15%">Usuario</th>
                                <th width="15%">Activo</th>
                              </tr>
                            </tfoot>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </form> 
            </div>
          </section>
        </div>
            <!-- /.row -->
            <!-- /.content -->
            <!-- </div> -->
            <!-- /.content-wrapper -->
        <?php include '../footer2.php'; ?>
        <!-- Control Sidebar -->
        <!-- /.control-sidebar -->
        <!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
        <div class="control-sidebar-bg"></div>
      </div>
      <!-- ./wrapper -->
      <?php include '../footer.php'; ?>
      <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
      <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
      <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
      <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
      <!-- Page script -->
      <script>
        function ocultar(){
          $('#accionesSugeridas').hide();
          $('#gravedadIncidencias').hide();
          $('#incid').hide();
          $('#categ').hide();
          $('#tiposI').hide();
          $('#APSI').show();
          cargar_tablaApsi();
        }
        function ocultar1(){ 
          $('#accionesSugeridas').hide();
          $('#gravedadIncidencias').hide();
          $('#APSI').hide();
          $('#incid').hide();
          $('#tiposI').hide();
          $('#categ').show();
          cargar_tablaCategoria();
        }
        function ocultar2(){ 
          $('#accionesSugeridas').hide();
          $('#gravedadIncidencias').hide();
          $('#APSI').hide(); 
          $('#categ').hide();
          $('#tiposI').hide();
          $('#incid').show();
          cargar_tablaIncidencias();
        }
        function ocultar3(){ 
          $('#accionesSugeridas').hide();
          $('#APSI').hide(); 
          $('#categ').hide();
          $('#incid').hide();
          $('#tiposI').hide();
          $('#gravedadIncidencias').show();
          cargar_tablaGravedad();
        }
        function ocultar4(){ 
          $('#APSI').hide(); 
          $('#categ').hide();
          $('#incid').hide();
          $('#gravedadIncidencias').hide();
          $('#tiposI').hide();
          $('#accionesSugeridas').show();
          
          cargar_tablaAcciones();
        }
        function ocultar5(){ 
          $('#APSI').hide(); 
          $('#categ').hide();
          $('#incid').hide();
          $('#gravedadIncidencias').hide();
          $('#accionesSugeridas').hide();
          $('#tiposI').show();
          cargar_tablaTipos();
        }
        cargar_tablaApsi();
        function cargar_tablaApsi(){
          $('#lista_claves').dataTable().fnDestroy();
          $('#lista_claves').DataTable( {
            'language': {"url": "../plugins/DataTables/Spanish.json"},
            "paging":   false,
            "dom": 'Bfrtip',
            buttons: [
              {
                extend: 'pageLength',
                text: 'Registros',
                className: 'btn btn-default'
              },
              {
                extend: 'excel',
                text: 'Exportar a Excel',
                className: 'btn btn-default',
                title: 'Control Equipos',
                exportOptions: 
                  {
                    columns: ':visible'
                  }
              },
              {
                extend: 'pdf',
                text: 'Exportar a PDF',
                className: 'btn btn-default',
                title: 'Control Equipos',
                exportOptions: 
                {
                  columns: ':visible'
                }
              },
              {
                extend: 'copy',
                text: 'Copiar registros',
                className: 'btn btn-default',
                copyTitle: 'Ajouté au presse-papiers',
                copyKeys: 'Appuyez sur <i>ctrl</i> ou <i>\u2318</i> + <i>C</i> pour copier les données du tableau à votre presse-papiers. <br><br>Pour annuler, cliquez sur ce message ou appuyez sur Echap.',
                copySuccess: {
                  _: '%d lignes copiées',
                  1: '1 ligne copiée'
                }
              }
            ],
            "ajax": {
                "type": "POST",
                "url": "tabla_claves.php",
                "dataSrc": ""
            },
            "columns": [
                { "data": "id" },
                { "data": "clave" },
                { "data": "nombre" },
                { "data": "usuario" },
                { "data": "activo" }
            ]
          });
        }
        function cargar_tablaCategoria(){
          $('#lista_categorias').dataTable().fnDestroy();
          $('#lista_categorias').DataTable
          ( 
            {
              'language': {"url": "../plugins/DataTables/Spanish.json"},
              "paging":   false,
              "dom": 'Bfrtip',
              buttons: 
              [
                {
                  extend: 'pageLength',
                  text: 'Registros',
                  className: 'btn btn-default'
                },
                {
                  extend: 'excel',
                  text: 'Exportar a Excel',
                  className: 'btn btn-default',
                  title: 'Control Equipos',
                  exportOptions: {
                    columns: ':visible'
                  }
                },
                {
                  extend: 'pdf',
                  text: 'Exportar a PDF',
                  className: 'btn btn-default',
                  title: 'Control Equipos',
                  exportOptions: {
                    columns: ':visible'
                  }
                },
                {
                  extend: 'copy',
                  text: 'Copiar registros',
                  className: 'btn btn-default',
                  copyTitle: 'Ajouté au presse-papiers',
                  copyKeys: 'Appuyez sur <i>ctrl</i> ou <i>\u2318</i> + <i>C</i> pour copier les données du tableau à votre presse-papiers. <br><br>Pour annuler, cliquez sur ce message ou appuyez sur Echap.',
                  copySuccess: {
                    _: '%d lignes copiées',
                    1: '1 ligne copiée'
                  }
                }
              ],
              "ajax": 
                {
                  "type": "POST",
                  "url": "tabla_categorias.php",
                  "dataSrc": ""
                },
              "columns": [
                { "data": "id" },
                { "data": "categoria" },
                { "data": "usuario" },
                { "data": "activo" }
              ]
            }
          );
        }
        function cargar_tablaIncidencias(){
          $('#lista_incidencias').dataTable().fnDestroy();
          $('#lista_incidencias').DataTable( {
              'language': {"url": "../plugins/DataTables/Spanish.json"},
              "paging":   false,
              "dom": 'Bfrtip',
              buttons: [{
                  extend: 'pageLength',
                  text: 'Registros',
                  className: 'btn btn-default'
                },
                {
                  extend: 'excel',
                  text: 'Exportar a Excel',
                  className: 'btn btn-default',
                  title: 'Control Equipos',
                  exportOptions: {
                    columns: ':visible'
                  }
                },
                {
                  extend: 'pdf',
                  text: 'Exportar a PDF',
                  className: 'btn btn-default',
                  title: 'Control Equipos',
                  exportOptions: {
                    columns: ':visible'
                  }
                },
                {
                  extend: 'copy',
                  text: 'Copiar registros',
                  className: 'btn btn-default',
                  copyTitle: 'Ajouté au presse-papiers',
                  copyKeys: 'Appuyez sur <i>ctrl</i> ou <i>\u2318</i> + <i>C</i> pour copier les données du tableau à votre presse-papiers. <br><br>Pour annuler, cliquez sur ce message ou appuyez sur Echap.',
                  copySuccess: {
                    _: '%d lignes copiées',
                    1: '1 ligne copiée'
                  }
                }
              ],
              "ajax": {
                  "type": "POST",
                  "url": "tabla_incidencias.php",
                  "dataSrc": ""
              },
              "columns": [
                  { "data": "id" },
                  { "data": "incidencia" },
                  { "data": "categoria" },
                  { "data": "tipo" },
                  { "data": "gravedad" },
                  { "data": "accion_sugerida" },
                  { "data": "activo" }
              ]
            }
          );
        }
        function cargar_tablaGravedad(){
          $('#lista_gravedades').dataTable().fnDestroy();
          $('#lista_gravedades').DataTable( {
              'language': {"url": "../plugins/DataTables/Spanish.json"},
              "paging":   false,
              "dom": 'Bfrtip',
              buttons: [{
                  extend: 'pageLength',
                  text: 'Registros',
                  className: 'btn btn-default'
                },
                {
                  extend: 'excel',
                  text: 'Exportar a Excel',
                  className: 'btn btn-default',
                  title: 'Control Equipos',
                  exportOptions: {
                    columns: ':visible'
                  }
                },
                {
                  extend: 'pdf',
                  text: 'Exportar a PDF',
                  className: 'btn btn-default',
                  title: 'Control Equipos',
                  exportOptions: {
                    columns: ':visible'
                  }
                },
                {
                  extend: 'copy',
                  text: 'Copiar registros',
                  className: 'btn btn-default',
                  copyTitle: 'Ajouté au presse-papiers',
                  copyKeys: 'Appuyez sur <i>ctrl</i> ou <i>\u2318</i> + <i>C</i> pour copier les données du tableau à votre presse-papiers. <br><br>Pour annuler, cliquez sur ce message ou appuyez sur Echap.',
                  copySuccess: {
                    _: '%d lignes copiées',
                    1: '1 ligne copiée'
                  }
                }
              ],
              "ajax": {
                  "type": "POST",
                  "url": "tabla_gravedades.php",
                  "dataSrc": ""
              },
              "columns": [
                  { "data": "id" },
                  { "data": "gravedad" },
                  { "data": "usuario" },
                  { "data": "activo" }
              ]
          });
        }
        function cargar_tablaAcciones(){
          $('#lista_acciones').dataTable().fnDestroy();
          $('#lista_acciones').DataTable( {
              'language': {"url": "../plugins/DataTables/Spanish.json"},
              "paging":   false,
              "dom": 'Bfrtip',
              buttons: [{
                  extend: 'pageLength',
                  text: 'Registros',
                  className: 'btn btn-default'
                },
                {
                  extend: 'excel',
                  text: 'Exportar a Excel',
                  className: 'btn btn-default',
                  title: 'Control Equipos',
                  exportOptions: {
                    columns: ':visible'
                  }
                },
                {
                  extend: 'pdf',
                  text: 'Exportar a PDF',
                  className: 'btn btn-default',
                  title: 'Control Equipos',
                  exportOptions: {
                    columns: ':visible'
                  }
                },
                {
                  extend: 'copy',
                  text: 'Copiar registros',
                  className: 'btn btn-default',
                  copyTitle: 'Ajouté au presse-papiers',
                  copyKeys: 'Appuyez sur <i>ctrl</i> ou <i>\u2318</i> + <i>C</i> pour copier les données du tableau à votre presse-papiers. <br><br>Pour annuler, cliquez sur ce message ou appuyez sur Echap.',
                  copySuccess: {
                    _: '%d lignes copiées',
                    1: '1 ligne copiée'
                  }
                }
              ],
              "ajax": {
                  "type": "POST",
                  "url": "tabla_acciones.php",
                  "dataSrc": ""
              },
              "columns": [
                  { "data": "id" },
                  { "data": "accion_sugerida" },
                  { "data": "usuario" },
                  { "data": "activo" }
              ]
          });
        }
        function cargar_tablaTipos(){
          $('#lista_tipos').dataTable().fnDestroy();
          $('#lista_tipos').DataTable( {
              'language': {"url": "../plugins/DataTables/Spanish.json"},
              "paging":   false,
              "dom": 'Bfrtip',
              buttons: [{
                  extend: 'pageLength',
                  text: 'Registros',
                  className: 'btn btn-default'
                },
                {
                  extend: 'excel',
                  text: 'Exportar a Excel',
                  className: 'btn btn-default',
                  title: 'Control Equipos',
                  exportOptions: {
                    columns: ':visible'
                  }
                },
                {
                  extend: 'pdf',
                  text: 'Exportar a PDF',
                  className: 'btn btn-default',
                  title: 'Control Equipos',
                  exportOptions: {
                    columns: ':visible'
                  }
                },
                {
                  extend: 'copy',
                  text: 'Copiar registros',
                  className: 'btn btn-default',
                  copyTitle: 'Ajouté au presse-papiers',
                  copyKeys: 'Appuyez sur <i>ctrl</i> ou <i>\u2318</i> + <i>C</i> pour copier les données du tableau à votre presse-papiers. <br><br>Pour annuler, cliquez sur ce message ou appuyez sur Echap.',
                  copySuccess: {
                    _: '%d lignes copiées',
                    1: '1 ligne copiée'
                  }
                }
              ],
              "ajax": {
                  "type": "POST",
                  "url": "tabla_tipos.php",
                  "dataSrc": ""
              },
              "columns": [
                  { "data": "id" },
                  { "data": "tipo" },
                  { "data": "categoria" },
                  { "data": "usuario" },
                  { "data": "activo" }
              ]
          });
        }
        function guardar() {
          $.ajax({
          url: 'insertar_claveAPSI.php',
          type: 'POST',
          dateType: 'html',
          data: $('#form_datos').serialize(),
          success: function(respuesta) {
          if (respuesta == "ok_nuevo") {
            alertify.success("Se ha Guardado el registro");
            cargar_tablaApsi();
            $(":text").val(''); //Limpiar los campos tipo Text
          } else if(respuesta == "ok_actualizado"){
            alertify.success("Se ha actualizado el registro correctamente");
            cargar_tablaApsi();
            $(":text").val('');
          }
          else if (respuesta == "vacio") {
            alertify.error("Verifica Campos");
          } else {
            alert(respuesta);
            alertify.error("Ha Ocurrido un Error");
              }
            }
          });
        }
        function guardar1(){
            $.ajax({
              url: 'insertar_categoria.php',
              type: 'POST',
              dateType: 'html',
              data: $('#cat').serialize(),
              success: function(respuesta) {
                if (respuesta == "ok_nuevo") {
                  alertify.success("Se ha Guardado el registro");
                  cargar_tablaCategoria();
                  $(":text").val(''); //Limpiar los campos tipo Text
                }else if(respuesta == "ok_actualizado"){
                  alertify.success("El registro se ha actualizado correctamente")
                  cargar_tablaCategoria();
                  $(":text").val('');
                } 
                else if (respuesta == "vacio") {
                  alertify.error("Verifica Campos");
                } else {
                  alert(respuesta);
                  alertify.error("Ha Ocurrido un Error");
                }
              }
            });
        }
        function cancelar() {
          $(":text").val(''); //Limpiar los campos tipo Text
          $('#categoriaa').val("").trigger('change.select2');
          $('#accion').val("").trigger('change.select2');
          $('#gravedad').val("").trigger('change.select2');
          alertify.success("Acción cancelada");
        }
        function guardar2() {
            $.ajax({
            url: 'insertar_incidencias.php',
            type: 'POST',
            dateType: 'html',
            data: $('#form_incidencias').serialize(),
            success: function(respuesta) {
              if (respuesta == "ok_nuevo") {
                alertify.success("Se ha Guardado el registro");
                cargar_tablaIncidencias();
                $(":text").val(''); //Limpiar los campos tipo Text
                $('#categoriaa').val("").trigger('change.select2');
                $("#gravedad").val("").trigger('change.select2');
                $("#accion").val('').trigger('change.select2');
                $("#tipoIn").val('').trigger('change.select2');
              } else if(respuesta=="ok_actualizado"){
                alertify.success("El registro se ha actualizado correctamente");
                $(":text").val(''); //Limpiar los campos tipo Text
                $('#categoriaa').val("").trigger('change.select2');
                $("#gravedad").val("").trigger('change.select2');
                $("#accion").val('').trigger('change.select2');
                $("#tipoIn").val('').trigger('change.select2');
                cargar_tablaIncidencias();
              }
              else if (respuesta == "vacio") {
                alertify.error("Verifica Campos");
              } else {
                alert(respuesta);
                alertify.error("Ha Ocurrido un Error");
              }
            }
          });
        }
        function guardarTipo(){
            $.ajax({
              url: 'insertar_tipos.php',
              type: 'POST',
              dateType: 'html',
              data: $('#tipoI').serialize(),
              success: function(respuesta) {
                if (respuesta == "ok_nuevo") {
                  alertify.success("Se ha Guardado el registro");
                  cargar_tablaTipos();
                  $(":text").val(''); //Limpiar los campos tipo Text
                } else if(respuesta=="ok_actualizado"){
                  alertify.success("El registro se ha actualizado correctamente");
                  $(":text").val(''); //Limpiar los campos tipo Text
                  cargar_tablaTipos();
                }
                else if (respuesta == "vacio") {
                  alertify.error("Verifica Campos");
                } else {
                  alert(respuesta);
                  alertify.error("Ha Ocurrido un Error");
                }
              }
          });
        }
        $( document ).ready( function () {
          $( "#form_datos" ).validate( {
            rules: {
              nombre:    "required",
              gravedad:  "required",
              categoria: "required",
              accion:    "required",
              formato:   "required",
            },
            messages: {
              nombre:    "Campo requerido",
              gravedad:  "Campo requerido",
              categoria: "Campo requerido",
              accion:    "Campo requerido",
              formato:   "Campo requerido",
            },
            errorElement: "em",
            errorPlacement: function ( error, element ) {
              error.addClass( "help-block" );

              if ( element.prop( "type" ) === "checkbox" ) {
                error.insertAfter( element.parent( "label" ) );
              } else {
                error.insertAfter( element );
              }
            },
            highlight: function ( element, errorClass, validClass ) {
              $( element ).parents( ".col-md-3" ).addClass( "has-error" ).removeClass( "has-success" );
              $( element ).parents( ".col-md-4" ).addClass( "has-error" ).removeClass( "has-success" );
              $( element ).parents( ".col-md-6" ).addClass( "has-error" ).removeClass( "has-success" );
            },
            unhighlight: function (element, errorClass, validClass) {
              $( element ).parents( ".col-md-3" ).addClass( "has-success" ).removeClass( "has-error" );
              $( element ).parents( ".col-md-4" ).addClass( "has-success" ).removeClass( "has-error" );
              $( element ).parents( ".col-md-6" ).addClass( "has-success" ).removeClass( "has-error" );
            }
          });
        });
      </script>
      <script>
        $(function () {
          $('.select').select2({
            placeholder: 'Seleccione una opción',
            lenguage: 'es'
          })
        })
        $(function () {
          $('#formato').select2({
            placeholder: 'Seleccione una opción',
            lenguage: 'es',
            ajax: { 
          url: "select_formato.php",
          type: "post",
          dataType: 'json',
          delay: 250,
          data: function (params) {
            return {
              searchTerm: params.term // search term
            };
          },
          processResults: function (response) {
            return {
                results: response
            };
          },
          cache: true
          }
          })
        }); 
        // $(function () {
        //   $('#categoriaT').select2({
        //     placeholder: 'Seleccione una opción',
        //     lenguage: 'es',
        //     ajax: { 
        //   url: "select_categoria.php",
        //   type: "post",
        //   dataType: 'json',
        //   delay: 250,
        //   data: function (params) {
        //     return {
        //       searchTerm: params.term // search term
        //     };
        //   },
        //   processResults: function (response) {
        //     return {
        //         results: response
        //     };
        //   },
        //   cache: true
        //   }
        //   })
        // });
        $(function () {
          $('#tipoIn').select2({
            placeholder: 'Seleccione una opción',
            lenguage: 'es',
            ajax: { 
          url: "select_tipo.php",
          type: "post",
          dataType: 'json',
          delay: 250,
          data: function (params) {
            return {
              searchTerm: params.term // search term
            };
          },
          processResults: function (response) {
            return {
                results: response
            };
          },
          cache: true
          }
          })
        }); 
        $(function () {
          $('#accion').select2({
            placeholder: 'Seleccione una opción',
            lenguage: 'es',
            ajax: { 
          url: "select_accion.php",
          type: "post",
          dataType: 'json',
          delay: 250,
          data: function (params) {
            return {
              searchTerm: params.term // search term
            };
          },
          processResults: function (response) {
            return {
                results: response
            };
          },
          cache: true
          }
          })
        }); 
        $(function () {
          $('#gravedad').select2({
            placeholder: 'Seleccione una opción',
            lenguage: 'es',
            ajax: { 
          url: "select_gravedad.php",
          type: "post",
          dataType: 'json',
          delay: 250,
          data: function (params) {
            return {
              searchTerm: params.term // search term
            };
          },
          processResults: function (response) {
            return {
                results: response
            };
          },
          cache: true
          }
          })
        });
        // $(function () {
        //   $('#categoriaa').select2({
        //     placeholder: 'Seleccione una opción',
        //     lenguage: 'es',
        //     ajax: { 
        //   url: "select_categoria.php",
        //   type: "post",
        //   dataType: 'json',
        //   delay: 250,
        //   data: function (params) {
        //     return {
        //       searchTerm: params.term // search term
        //     };
        //   },
        //   processResults: function (response) {
        //     return {
        //         results: response
        //     };
        //   },
        //   cache: true
        //   }
        //   })
        // }); 
        function editarClaves(id){
          var url = 'consulta_datos_editarI.php';
          $.ajax({
            url: url,
            type: "POST",
            dateType: "html",
            data: {id: id},
            success: function(respuesta) {
              var array = eval(respuesta);
              $("#id_registroo").val(array[0]);
              $("#claveApsi").val(array[1]);
              $("#nombre").val(array[2]);
            },
          });
        }
        function editarCategorias(id){
          var url = 'consulta_datos_editarC.php';
          $.ajax({
            url: url,
            type: "POST",
            dateType: "html",
            data: {id: id},
            success: function(respuesta) {
              var array = eval(respuesta);
              $("#id_registro1").val(array[0]);
              $("#categoria").val(array[1]);
            },
          });
        }
        function editarTipos(id){
          var url = 'consulta_datos_editarT.php';
          $.ajax({
            url: url,
            type: "POST",
            dateType: "html",
            data: {id: id},
            success: function(respuesta) {
              var array = eval(respuesta);
              $("#id_registro6").val(array[0]);
              $("#tipo").val(array[1]);
              $("#categoriaT").select2("trigger", "select", {
              data: {
                id: array[2],
                text: array[3]
              }
            });
            },
          });
        }
        function editarIncidencias(id){
          var url = 'consulta_datos_editarIn.php';
          $.ajax({
            url: url,
            type: "POST",
            dateType: "html",
            data: {id: id},
            success: function(respuesta) {
              var array = eval(respuesta);
              $("#id_registro2").val(array[0]);
              $("#incidencia").val(array[1]);
            //   $("#categoriaa").select2("trigger", "select", {
            //   data: {
            //     id: array[2],
            //     text: array[3]
            //   }
            // });
            $("#gravedad").select2("trigger", "select", {
              data: {
                id: array[6],
                text: array[7]
              }
            });
            $("#accion").select2("trigger", "select", {
              data: {
                id: array[4],
                text: array[5]
              }
            });
            $("#tipoIn").select2("trigger", "select", {
              data: {
                id: array[9],
                text: array[10]
              }
            });
            },
          });
        }
        // acciones
        function estatus(registro){
          var id_registro = registro;
          var url = 'cambiar_estatusAcciones.php';
          $.ajax({
            url: url,
            type: "POST",
            dateType: "html",
            data: {id_registro: id_registro},
            success: function(respuesta) {
              if (respuesta=="ok") {
                alertify.success("Registro modificado correctamente");
                cargar_tablaAcciones();
              }
            },
            error: function(xhr, status) {
                alert("error");
            },
          });
        }
        function estatusTipos(registro){
          var id_registro = registro;
          var url = 'cambiar_estatusTipos.php';
          $.ajax({
            url: url,
            type: "POST",
            dateType: "html",
            data: {id_registro: id_registro},
            success: function(respuesta) {
              if (respuesta=="ok") {
                alertify.success("Registro modificado correctamente");
                cargar_tablaTipos();
              }
            },
            error: function(xhr, status) {
                alert("error");
            },
          });
        }
        // gravedad
        function estatusGravedad(registro){
          var id_registro = registro;
          var url = 'cambiar_estatusGravedad.php';
          $.ajax({
            url: url,
            type: "POST",
            dateType: "html",
            data: {id_registro: id_registro},
            success: function(respuesta) {
              if (respuesta=="ok") {
                alertify.success("Registro modificado correctamente");
                cargar_tablaGravedad();
              }
            },
            error: function(xhr, status) {
                alert("error");
            },
          });
        }
        //claves apsi
        function estatusClaves(registro){
          var id_registro = registro;
          var url = 'cambiar_estatusClaves.php';
          $.ajax({
            url: url,
            type: "POST",
            dateType: "html",
            data: {id_registro: id_registro},
            success: function(respuesta) {
              if (respuesta=="ok") {
                alertify.success("Registro modificado correctamente");
                cargar_tablaApsi();
              }
            },
            error: function(xhr, status) {
                alert("error");
            },
          });
        }
        // categorias
        function estatusCategorias(registro){
          var id_registro = registro;
          var url = 'cambiar_estatusCategorias.php';
          $.ajax({
            url: url,
            type: "POST",
            dateType: "html",
            data: {id_registro: id_registro},
            success: function(respuesta) {
              if (respuesta=="ok") {
                alertify.success("Registro modificado correctamente");
                cargar_tablaCategoria();
              }
            },
            error: function(xhr, status) {
                alert("error");
            },
          });
        }
        // incidencias
        function estatusIncidencias(registro){
          var id_registro = registro;
          var url = 'cambiar_estatusIncidencias.php';
          $.ajax({
            url: url,
            type: "POST",
            dateType: "html",
            data: {id_registro: id_registro},
            success: function(respuesta) {
              if (respuesta=="ok") {
                alertify.success("Registro modificado correctamente");
                cargar_tablaIncidencias();
              }
            },
            error: function(xhr, status) {
                alert("error");
                //alert(xhr);
            },
          });
        }
      </script>
    </body>
  </html>