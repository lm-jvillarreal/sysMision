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
                <h3 class="box-title">Registro de Incidencias</h3>
              </div>
              <div class="box-body">
                <div class="tabbable">
                  <ul class="nav nav-tabs">
                    <li class="active"><a href="#1" data-toggle="tab" id="empleados" onclick="ocultar()">Incidencias a Empleados</a></li>
                    <li><a href="#2" data-toggle="tab" id="promotores" onclick="ocultar1()">Incidencias a promotores</a></li>
                  </ul>
                  <div class="tab-content">
                    <div class="tab-pane active"id="1">
                      <form method="POST" id="form_datos">
                        <br>
                        <div class="row">
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="id_persona">*Nombre</label>
                              <input type="hidden" name="id_registro" id="id_registro">
                              <select name="id_persona" id="id_persona" class="form-control select2" onchange="llenar()" >
                                <option value=""></option>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="departamento">*Departamento</label>
                              <input type="text" name="departamento" id="departamento" class="form-control" readonly>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="sucursal">*Sucursal</label>
                              <input type="text" name="sucursal" id="sucursal" class="form-control" readonly>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="categoria">*Categoría</label>
                              <input type="text" name="categoria" id="categoria" class="form-control" value="Indisciplina"readonly>
                              <!-- <select name="categoria" id="categoria" class="form-control select2" readonly> -->
                                <!-- <option value="1">Indisciplina</option> -->
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="tipo">*Tipo</label>
                              <select name="tipo" id="tipo" class="form-control select2">
                                <option value=""></option>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="incidencia">*Incidencia</label>
                              <select name="incidencia" id="incidencia" class="form-control select2" onchange="selectAccion()">
                              <option value=""></option>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="accion">*Acción Sugerida</label>
                              <input type="text" name="accion" id="accion" class="form-control" readonly>
                            </div>
                          </div>
                          
		                      <div class="col-md-3">
                            <div class="form-group">
                              <label for="comentario">*Comentario</label>
                              <textarea id="comentario" class="form-control" name="comentario" placeholder="Agregue un comentario..."></textarea>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="vigilante">*Vigilante:</label>
                              <select name="vigilante" id="vigilante" class="form-control select2">
                              <option value=""></option>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="box-footer text-right">
                          <button type="button" class="btn btn-success pull-left"id="limpiar" onclick="limpiarE();" style="display:none">Limpiar</button>
                          <button type="button" class="btn btn-danger" id="cancel" onclick="campos_llenosE();">Cancelar</button>
                          <!-- el boton limpiar limpia los campos y guarda el registro con estatus de cancelado y
                          un comentario haciendo alucion de que el empleado no acepto la incidencia -->
                          <button type="button" class="btn btn-warning" id="guardar" onclick="campos_llenos();">Guardar</button>
                        </div>
                      </form>
                    </div>
                    <div class="tab-pane"id="2">
                      <form method="POST" id="form_promotores">
                        <br>
                        <div class="row">
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="id_promotor">*Nombre:</label>
                              <input type="hidden" name="id_registroo" id="id_registroo">
                              <select name="id_promotor" id="id_promotor" class="form-control select2" style="width:250px"onchange="llenarP()">
                                <option value=""></option>
                              </select>
                              <input type="hidden" name="nombre" id="nombre">
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="compañia">*Compañía:</label>
                              <input type="text" name="compañia" id="compañia" class="form-control" readonly>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="categoriaP">*Categoría:</label>
                              <select name="categoriaP" id="categoriaP" class="form-control select2"style="width:250px">
                                <option value="1">Indisciplina</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="tipop">*Tipo:</label>
                              <select name="tipop" id="tipop" class="form-control select2"style="width:250px">
                                <option value=""></option>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="incidenciaP">*Incidencia:</label>
                              <select name="incidenciaP" id="incidenciaP" class="form-control select2"style="width:250px" onchange="selectAccionP()">
                              </select>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="accionP">*Acción Sugerida:</label>
                              <input type="text" name="accionP" id="accionP" class="form-control" readonly>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="comentarioP">*Comentario:</label>
                              <textarea id="comentarioP" class="form-control" name="comentarioP" placeholder="Agregue un comentario..."></textarea>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="vigilanteP">*Vigilante:</label>
                              <select name="vigilanteP" id="vigilanteP" class="form-control select2"style="width:250px">
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="box-footer text-right">
                          <button type="button" class="btn btn-danger" id="cancelP" onclick="campos_llenosCP();">Cancelar</button>
                          <button type="button" class="btn btn-success pull-left" id="limpiarPr" onclick="limpiarP();"style="display:none">Limpiar</button>
                          <!-- el boton limpiar limpia los campos y guarda el registro con estatus de cancelado y
                          un comentario haciendo alucion de que el empleado no acepto la incidencia -->
                          <button type="button" class="btn btn-warning" id="guardarP" onclick="campos_llenosP();">Guardar</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div id="empleadosS">
              <form action="" id="tabla_empleados">
                <div class="box box-danger">
                  <div class="box-header">
                    <h3 class="box-title">Lista de Incidencias Empleados</h3>
                  </div>
                  <div class="box-body">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="table-responsive">
                          <table id="lista_incidencias" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                              <tr>
                                <th width = "5%"> ID</th>
                                <th width = "">No. Empleado</th>
                                <th width = "15%">Suc.</th>
                                <th width = "">Dpto.</th>
                                <th width = "15%">Incidencia</th>
                                <th width = "15%">Categoría</th> 
                                <th width = "5%">Tipo</th> 
                                <th width = "20%">Comentario</th>
                                <th width = "15%">Registra</th>
                                <th width = "15%">Fecha</th>
                                <th width = "5%"> Estado</th>
                                <th width = "5%"> Firma</th>
                                <th width = "10%">Acciones</th>
                              </tr>
                            </thead>
                            <tfoot>
                              <tr>
                                <th width = "5%" >ID</th>
                                <th width = "">No. Empleado</th>
                                <th width = "15%">Suc.</th>
                                <th width = "">Dpto.</th>
                                <th width = "15%">Incidencia</th>
                                <th width = "15%">Categoría</th> 
                                <th width = "5%">Tipo</th> 
                                <th width = "20%">Comentario</th>
                                <th width = "15%">Registra</th>
                                <th width = "15%">Fecha</th>
                                <th width = "5%" >Estado</th>
                                <th width = "5%"> Firma</th>
                                <th width = "10%" >Acciones</th>
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
            <div id="promotoresS" style="display:none">
              <form action="" id="tabla_promotores">
                <div class="box box-danger">
                  <div class="box-header">
                    <h3 class="box-title">Lista de Incidencias Promotores</h3>
                  </div>
                  <div class="box-body">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="table-responsive">
                          <table id="lista_promotores" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                              <tr>
                                <th width="5%"> ID</th>
                                <th width="35%">Promotor</th>
                                <th width="35%">Compañía</th>
                                <th width="35%">Sucursal</th>
                                <th width="15%">Incidencia</th>
                                <th width="15%">Categoría</th> 
                                <th width="15%">Tipo</th> 
                                <th width="15%">Comentario</th>
                                <th width="15%">Registra</th>
                                <th width="15%">Fecha</th>
                                <th width="5%"> Estado</th>
                                <th width="10%">Acciones</th>
                                
                              </tr>
                            </thead>
                            <tfoot>
                              <tr>
                                <th width = "5%" >ID</th>
                                <th width = "35%">Promotor</th>
                                <th width = "15%">Compañía.</th>
                                <th width = "35%">Sucursal</th>
                                <th width = "15%">Incidencia</th>
                                <th width = "15%">Categoría</th>
                                <th width="15%">Tipo</th>  
                                <th width = "15%">Comentario</th>
                                <th width="15%">Registra</th>
                                <th width="15%">Fecha</th>
                                <th width = "5%" >Estado</th>
                                <th width = "10%" >Acciones</th>
                                
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
              <!-- /.row -->
          </section>
            <!-- /.content -->
        </div>
          <!-- /.content-wrapper -->
          <?php include 'modal_firma.php'; ?>
          <?php include 'modal_firma2.php'; ?>
          <?php include 'modal_rechazar.php'; ?>
          <?php include 'modal_pagar.php'; ?>
          <?php include '../footer2.php'; ?>
          <!-- Control Sidebar -->
          <!-- /.control-sidebar -->
          <!-- Add the sidebar's background. This div must be placed
              immediately after the control sidebar -->
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
          $('#promotoresS').hide();
          $('#empleadosS').show();
          cargar_tablaEmpleados();
        }
        function ocultar1(){
          $('#empleadosS').hide();
          $('#promotoresS').show();
          cargar_tablaPromotores();
        }
        function cargar_tablaEmpleados(){
            var ide = $('#id_persona').val();
          $('#lista_incidencias').dataTable().fnDestroy();
          $('#lista_incidencias').DataTable( {
              'language': {"url": "../plugins/DataTables/Spanish.json"},
              "paging":   false,
              "dom": 'Bfrtip',
              "order": ["0", "ASC"],
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
                  "url": "tabla_registros.php",
                  "dataSrc": "",
                  "data":{ide:ide}
              },
              "columns": [
                { "data": "id" },
                { "data": "nombre" },
                { "data": "departamento" },
                { "data": "sucursal" },
                { "data": "incidencia" },
                { "data": "categoria" },
                { "data": "tipo"},
                { "data": "comentario" },
                { "data": "vigilante" },
                { "data": "fecha" },
                { "data": "activo"},
                { "data": "firma"},
                { "data": "autorizar"}
              ]
          });
        }
        cargar_tablaEmpleados();
        function cargar_tablaPromotores()
        {
          $('#lista_promotores').dataTable().fnDestroy();
          $('#lista_promotores').DataTable( 
            { 
              'language': {"url": "../plugins/DataTables/Spanish.json"},
              "paging":   false,
              "dom": 'Bfrtip',
              "order": ["0", "ASC"],
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
                  copySuccess: 
                  {
                    _: '%d lignes copiées',
                    1: '1 ligne copiée'
                  }
                }
              ],
              "ajax": 
              {
                "type": "POST",
                "url": "tabla_promotores.php",
                "dataSrc": "",
              },
              "columns": 
              [
                { "data": "id" },
                { "data": "nombre" },
                { "data": "compañia" },
                { "data": "sucursal" },
                { "data": "incidencia" },
                { "data": "categoria" },
                { "data": "tipo" },
                { "data": "comentario" },
                { "data": "vigilante" },
                { "data": "fecha" },
                { "data": "activo"},
                { "data": "autorizar"}
              ]
            }
          );
        }
        $(function () {
          $('#id_persona').select2(
            {
              placeholder: 'Seleccione una opcion',
              lenguage: 'es',
              //minimumResultsForSearch: Infinity
              ajax: { 
                url: "select_persona.php",
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
          $('#tipo').select2({
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
          $('#tipop').select2({
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
        $(function() 
        {
          $('#id_promotor').select2(
            {
              placeholder: 'Seleccione una opcion',
              lenguage: 'es',
              //minimumResultsForSearch: Infinity
              ajax: { 
                url: "select_promotor.php",
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
            }
          )
        });
        $(function () {
          $('#decisionN').select2({
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
        $.validator.setDefaults( {
          submitHandler: function () {
            var url = "insertar_registro.php"; // El script a dónde se realizará la petición.
            $.ajax({
              type: "POST",
              url: url,
              data: $("#form_datos").serialize(), // Adjuntar los campos del formulario enviado.
              success: function(respuesta)
                {
                  if (respuesta=="ok_nuevo") {
                    alertify.success("Registro guardado correctamente");
                  }else if(respuesta=="actualizado"){
                    alertify.success("Registro actualizado correctamente");
                  }else if(respuesta=="duplicado"){
                    alertify.error("El registro ya existe");
                  }else {
                    alertify.error("Ha ocurrido un error");
                  }
                  //$(":text").val(''); //Limpiar los campos tipo Text
                  $('#comentario').val("");
                  $('#departamento').val("");
                  $('#sucursal').val("");
                  $('#accion').val("");
                  $('#id_persona').val("").trigger('change.select2'); //limpiar campos select
                  $('#vigilante').val("").trigger('change.select2'); 
                  $('#tipo').val("").trigger('change.select2'); 
                  $('#incidencia').val("").trigger('change.select2');
                  cargar_tabla();
                }
            });
            // Evitar ejecutar el submit del formulario.
            return false;
          }
        });
        $( document ).ready( function () {
          $( "#form_datos" ).validate( {
            rules: {
              id_persona:   "required",
              departamento: "required",
              incidencia:   "required",
	            comentario:   "required",
              sucursal:     "required",
              categoria:    "required",
              tipo:         "required",
              accion:       "required",
              comentario:   "required",
              vigilante:    "required",
            },
            messages: {
              id_persona:   "Campo requerido",
              departamento: "Campo requerido",
              incidencia:   "Campo requerido",
	            comentario:   "Campo Requerido",
              sucursal:     "Campo Requerido",
              categoria:    "Campo Requerido",
              tipo:         "Campo Requerido",
              accion:       "Campo Requerido",
              comentario:   "Campo Requerido",
              vigilante:    "Campo Requerido",
            },
            errorElement: "em",
            errorPlacement: function ( error, element ) {
              // Add the `help-block` class to the error element
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
          $('#incidencia').select2(
            {
              placeholder: 'Seleccione una opcion',
              lenguage: 'es',
              //minimumResultsForSearch: Infinity
              ajax: { 
                url: "select_incidencia.php",
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                  var tipo= $('#tipo').val();
                  return {
                    searchTerm: params.term,
                    tipo:tipo // search term
                  };
                },
                processResults: function (response) {
                  return {
                    results: response
                  };
                },
                cache: true
              }
            }
          )
        });
        $(function (){
          $('#incidenciaP').select2({
            placeholder: 'Seleccione una opcion',
            lenguage: 'es',
            //minimumResultsForSearch: Infinity
            ajax: 
            { 
              url: "select_incidencia.php",
              type: "post",
              dataType: 'json',
              delay: 250,
              data: function (params) {
                var tipo= $('#tipop').val();
                return {
                  searchTerm: params.term,
                  tipo:tipo // search term
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
          $('#vigilante').select2({
            placeholder: 'Seleccione una opcion',
            lenguage: 'es',
            //minimumResultsForSearch: Infinity
            ajax: { 
              url: "select_vigilante.php",
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
          $('#vigilanteP').select2({
            placeholder: 'Seleccione una opcion',
            lenguage: 'es',
            //minimumResultsForSearch: Infinity
            ajax: { 
              url: "select_vigilante.php",
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
        function editar(id){
          $('#limpiar').show();
          var url = 'consulta_datos_editar_incidencias.php';
          $.ajax({
            url: url,
            type: "POST",
            dateType: "html",
            data: {id: id},
            success: function(respuesta) {
              var array = eval(respuesta);
              $("#id_registro").val(array[0]);
              $("#id_persona").select2("trigger", "select", {
                data: { id: array[1], text: array[2] }
              });
              $("#categoria").select2("trigger", "select", {
                data: { id: array[3], text: array[4] }
              });
              $("#incidencia").select2("trigger", "select", {
                data: { id: array[5], text: array[6] }
              });
              $("#comentario").val(array[8]);
              $("#vigilante").select2("trigger", "select", {
                data: { id: array[11], text: array[12] }
              });
            },
          });
        }
        function editarP(id){
          $('#limpiarPr').show();
          var url = 'consulta_datos_editar_incidencias_P.php';
          $.ajax({
            url: url,
            type: "POST",
            dateType: "html",
            data: {id: id},
            success: function(respuesta) {
              var array = eval(respuesta);
              $("#id_registroo").val(array[0]);
              $("#id_promotor").select2("trigger", "select", {
                data: { id: array[1], text: array[2] }
              });
              $("#categoriaP").val(array[3]);
              // $("#categoriaP").select2("trigger", "select", {
              //   data: { id: array[3], text: array[4] }
              // });
              $("#incidenciaP").select2("trigger", "select", {
                data: { id: array[5], text: array[6] }
              });
              $("#comentarioP").val(array[8]);
              $("#vigilanteP").select2("trigger", "select", {
                data: { id: array[11], text: array[12] }
              });
            },
          });
        }
        function autorizacion(registro){
          var id_registro = registro;
          var url = 'cambiar_estatus.php';
          $.ajax({
            url: url,
            type: "POST",
            dateType: "html",
            data: {id_registro: id_registro},
            success: function(respuesta) {
              if (respuesta=="ok") {
                alertify.success("Incidencia Autorizada");
                $("#modal-pagar").modal("hide");
                cargar_tablaEmpleados();
                cargar_tablaPromotores();
              }
            },
            error: function(xhr, status) {
              alert("error");
              //alert(xhr);
            },
          });
        }
        //inicia funcion firma abre el modal para ingresar la firma, el boton del modal manda llamar la funcion para insertar en bd  
        function firma(registro){
           $("#modal-default").modal("show");
          }
        //termina funcion para abrir modal

        //inicia funcion para validar que la firma del empleado coincide al insertawr el registro en bd
        function validar(clave){
          var clave = $("#clave1").val();
          var match = $("#clave").val();
          if(clave==match){
            $.ajax({
              url: 'insertar_registro.php',
              type: "POST",
              dateType: "html",
              data: $("#form_datos").serialize(),
              success: function(respuesta) {
                if(respuesta == "ok"){
                  alertify.success("Registro insertado correctamente");
                  $("#modal-default").modal("hide");
                  //$(":text").val(''); //Limpiar los campos tipo Text
                  $('#departamento').val('');
                  $('#sucursal').val('');
                  $('#comentario').val('');
                  $('#accion').val('');

                  $('#id_persona').val("").trigger('change.select2');
                  $('#tipo').val("").trigger('change.select2'); //limpiar campos select
                  $('#vigilante').val("").trigger('change.select2');
                  //$('#categoria').val("").trigger('change.select2');
                  $('#incidencia').val("").trigger('change.select2');
                  cargar_tablaEmpleados();  
                }else if(respuesta == "actualizado")
                {
                  alertify.success("Registro modificado correctamente");
                  $("#modal-default").modal("hide");
                  $(":text").val(''); //Limpiar los campos tipo Text
                  $('#comentario').val('');
                  $('#id_persona').val("").trigger('change.select2'); //limpiar campos select
                  $('#categoria').val("").trigger('change.select2');
                  $('#incidencia').val("").trigger('change.select2');
                  cargar_tablaEmpleados();
                }
              },
              error: function(xhr, status) {
                alert("error");
              },
            }); 
          }else if(clave =="")
          {
            alertify.error("Es necesario que ingrese los datos solicitados...");
          }else{
            alertify.error("Es necesario que ingrese los datos solicitados...");
          }
        }
        //termina funcion para validar firma de empleado coincide al insertar el registro en la bd

        //incia funcion que inserta desde la tabla la firma del empleado
        function validarFirma(claveFirma){
          var claveFirma = $("#claveFirma").val();
          var confclave = $("#confclave").val();
          var id_registro = $("#registro").val();
          if(claveFirma==confclave){
            $.ajax({
              url: 'agregar_firma.php',
              type: "POST",
              dateType: "html",
              data: {claveFirma:claveFirma, confclave:confclave, id_registro:id_registro},
              success: function(respuesta) {
                if(respuesta == "ok"){
                  alertify.success("Firma registrada correctamente");
                  $("#modal-firmar").modal("hide");
                  cargar_tablaEmpleados();  
                }else
                {
                  alertify.error("Error al registrar la firma");
                }
              },
              error: function(xhr, status) {
                alert("error");
              },
            }); 
          }else if(claveFirma =="")
          {
            alertify.error("Es necesario que ingreses los datos solicitados");
          }else
          {
            alertify.error("Los datos no coinciden");
          }
        }
        //finaliza función que inserta desde la tabla la firma del empleado

        //inicia funcion para insertar incidencia en base de datos sin firma del empleado
        function insertarSf(clave)
        {
          $.ajax({
            url: 'insertar_registro_sf.php',
            type: "POST",
            dateType: "html",
            data: $("#form_datos").serialize(),
            success: function(respuesta) {
              if(respuesta == "ok"){
                alertify.success("Registro insertado correctamente");
                $("#modal-default").modal("hide");
               //$(":text").val(''); //Limpiar los campos tipo Text
                $('#comentario').val('');
                $('#departamento').val('');
                $('#sucursal').val('');
                $('#accion').val('');
                $('#id_persona').val("").trigger('change.select2'); //limpiar campos select
                //$('#categoria').val("").trigger('change.select2');
                $('#incidencia').val("").trigger('change.select2');
                $('#tipo').val("").trigger('change.select2');
                $('#vigilante').val("").trigger('change.select2');
                cargar_tablaEmpleados();  
              }else if(respuesta == "actualizado")
              {
                alertify.success("Registro modificado correctamente");
                $("#modal-default").modal("hide");
                //$(":text").val(''); //Limpiar los campos tipo Text
                $('#comentario').val('');
                $('#departamento').val('');
                $('#sucursal').val('');
                $('#accion').val('');
                $('#id_persona').val("").trigger('change.select2'); //limpiar campos select
                //$('#categoria').val("").trigger('change.select2');
                $('#incidencia').val("").trigger('change.select2');
                cargar_tablaEmpleados();
              }
            },
            error: function(xhr, status) {
              alert("error");
            },
          });
        }
        //termina funcion que inserta incidencia en base de datos sin firma del empleado

        //inicia funcion para insertar el registro de incidencias a promotores
        function insertP()
        {
          $.ajax({
            url: 'insertar_registroP.php',
            type: "POST",
            dateType: "html",
            data: $("#form_promotores").serialize(),
            success: function(respuesta) {
              if(respuesta == "ok"){
                alertify.success("Registro insertado correctamente");
                $(":text").val(''); //Limpiar los campos tipo Text
                $("textarea").val('');
                $('#comentarioP').val('');
                $('#id_promotor').val("").trigger('change.select2'); //limpiar campos select
                $('#categoriaP').val("").trigger('change.select2');
                $('#incidenciaP').val("").trigger('change.select2');
                $('#vigilanteP').val("").trigger('change.select2');
                cargar_tablaPromotores();  
              }else if(respuesta == "actualizado")
              {
                alertify.success("Registro modificado correctamente");
                $(":text").val(''); //Limpiar los campos tipo Text
                $("textarea").val('');
                $('#comentarioP').val('');
                $('#id_promotor').val("").trigger('change.select2'); //limpiar campos select
                $('#categoriaP').val("").trigger('change.select2');
                $('#incidenciaP').val("").trigger('change.select2');
                $('#vigilanteP').val("").trigger('change.select2');
                cargar_tablaPromotores();
              }
            },
            error: function(xhr, status) {
              alert("error");
            },
          });
        }
        //termina funcion para insertar el registro de incidencias a promotores

        function campos_llenos(){
          if($("#id_persona").val()==""||$("#categoria").val()==""||$("#tipo").val()==""||$("#incidencia").val()==""||$("#vigilante").val()==""||$("#comentario").val()==""||$("#accion").val()=="")
          {
            alertify.error("Verifique los campos...");
          }else{
            firma();
          }
        }
        function campos_llenosE(){
          if($("#id_persona").val()==""||$("#categoria").val()==""||$("#incidencia").val()==""||$("#comentario").val()==""||$("#accion").val()==""||$("#vigilante").val()==""){
            alertify.error("Verifique los campos...");
          }else{
            cancelar();
          }
        }
        function campos_llenosP(){
          if($("#id_promotor").val()==""||$("#categoriaP").val()==""||$("#incidenciaP").val()==""||$("#comentarioP").val()==""||$("#accionP").val()==""||$("#vigilanteP").val()==""){
            alertify.error("Verifique los campos...");
          }else{
            insertP();
          }
        }
        function campos_llenosCP(){
          if($("#id_promotor").val()==""||$("#categoriaP").val()==""||$("#incidenciaP").val()==""||$("#comentarioP").val()==""||$("#accionP").val()==""||$("#vigilanteP").val()==""){
            alertify.error("Verifique los campos...");
          }else{
            cancelarP();
          }
        }
        function limpiarP(){
          $(":text").val(''); //Limpiar los campos tipo Text
          $("textarea").val('');
          $('#id_promotor').val("").trigger('change.select2'); //limpiar campos select
          $('#categoriaP').val("").trigger('change.select2');
          $('#incidenciaP').val("").trigger('change.select2');
          $('#vigilanteP').val("").trigger('change.select2');
        }
        function limpiarE(){
          $(":text").val(''); //Limpiar los campos tipo Text
          $("textarea").val('');
          $('#id_persona').val("").trigger('change.select2'); //limpiar campos select
          $('#categoria').val("").trigger('change.select2');
          $('#incidencia').val("").trigger('change.select2');
          $('#vigilante').val("").trigger('change.select2');
        }
        function cancelar(registro){
          var id_persona = registro;
          var url = 'cancelar_registro.php';
          $.ajax({
            url: url,
            type: "POST",
            dateType: "html",
            data: $("#form_datos").serialize(),
            success: function(respuesta) {
              if(respuesta == "ok"){
                alertify.error("Se ha cancelado el registro correctamente.");
                cargar_tablaEmpleados();
                $(":text").val(''); //Limpiar los campos tipo Text
                $('#id_persona').val("").trigger('change.select2'); //limpiar campos select
                $('#categoria').val("").trigger('change.select2');
                $('#incidencia').val("").trigger('change.select2');
                $('#vigilante').val("").trigger('change.select2');
              }
            },
            error: function(xhr, status) {
              alert("error");
              //alert(xhr);
            },
          });
        }
        function cancelarP(registro){
          var id_promotor = registro;
          var url = 'cancelar_registroP.php';
          $.ajax({
            url: url,
            type: "POST",
            dateType: "html",
            data: $("#form_promotores").serialize(),
            success: function(respuesta) {
              if(respuesta == "ok"){
                alertify.error("Se ha cancelado el registro correctamente.");
                cargar_tablaPromotores();
                $(":text").val(''); //Limpiar los campos tipo Text
                $("textarea").val('');
                $('#id_promotor').val("").trigger('change.select2'); //limpiar campos select
                $('#categoriaP').val("").trigger('change.select2');
                $('#incidenciaP').val("").trigger('change.select2');
                $('#vigilanteP').val("").trigger('change.select2');
              }
            },
            error: function(xhr, status) {
              alert("error");
              //alert(xhr);
            },
          });
        }
        function ayuda(){
        plantilla = 'PDF/res/img.png';
        window.open(plantilla, "_blank");
        }
        function llenar(){
          var id_persona = $('#id_persona').val();
          var id_registro =$('#id_registro').val();
          if (id_persona != ""){
            var url = 'llenar.php';
            $.ajax({
              url: url,
              type: "POST",
              dateType: "html",
              data: {'id_persona': id_persona},
              success: function(respuesta) {
                //evaluar el array y separarlo para imprimir por campos
                var array = eval(respuesta)
                //campo__14 sucursal array 0
                //campo__15 departamento array 1
                $('#departamento').val(array[1]);
                $('#sucursal').val(array[0]);
              },
              error: function(xhr, status) {
                  alert("error");
                  alert(xhr);
              },
            });
          }
        }
        function llenarP(){
          var id_promotor = $('#id_promotor').val();
          var id_registroo =$('#id_registroo').val();
          
          if (id_promotor != ""){
            var url = 'llenarp.php';
            $.ajax({
              url: url,
              type: "POST",
              dateType: "html",
              data: {'id_promotor': id_promotor},
              success: function(respuesta) {
                //evaluar el array y separarlo para imprimir por campos
                var array = eval(respuesta)
                //campo__14 sucursal array 0
                //campo__15 departamento array 1
                $('#compañia').val(array[0]);
                $('#nombre').val(array[1]);
              },
              error: function(xhr, status) {
                  alert("error");
                  alert(xhr);
              },
            });
          }
        }
        function selectAccion(){
          var incidencia = $('#incidencia').val();
          
          if (incidencia != ""){
            var url = 'select_accionSugerida.php';
            $.ajax({
              url: url,
              type: "POST",
              dateType: "html",
              data: {'incidencia': incidencia},
              success: function(respuesta) {
                var array = eval(respuesta)
                $("#accion").val(array[1]);
              },
              error: function(xhr, status) {
                  alert("error");
                  alert(xhr);
              },
            });
          }
        }
        function selectAccionP(){
          var incidencia = $('#incidenciaP').val();
          
          if (incidencia != ""){
            var url = 'select_accionSugerida.php';
            $.ajax({
              url: url,
              type: "POST",
              dateType: "html",
              data: {'incidencia': incidencia},
              success: function(respuesta) {
                var array = eval(respuesta)
                $("#accionP").val(array[1]);
              },
              error: function(xhr, status) {
                  alert("error");
                  alert(xhr);
              },
            });
          }
        }
        $('#modal-default').on('show.bs.modal', function(e) {
          var id_registro = $('#id_registro').val();
          var id_persona = $('#id_persona').val();
          var url = "consulta_firma.php"; // El script a dónde se realizará la petición.http://200.1.1.197/SMPruebas/mAutorizacionIncidencias/
            $.ajax({
              type: "POST",
              url: url,
              data: {'id_registro':id_registro, 'id_persona': id_persona}, // Adjuntar los campos del formulario enviado.
              success: function(respuesta)
              {
                var array = eval(respuesta);
                $('#nombreE').html(array[0]);
                $('#documento').html(array[1]);
                // $('#clave1').val(array[0]);
                $('#clave').val(array[2]);
              }
            });
        });
      
        function llenado(){
          var firma = $('#firma').val();
          var id_registro = $('#id_registro').val();
          var id_persona = $('#id_persona').val();
          if (firma != ""){
            var url = 'consulta_firma.php';
            $.ajax({
              url: url,
              type: "POST",
              dateType: "html",
              data: {'firma': firma, 'id_registro': id_registro, 'id_persona': id_persona},
              success: function(respuesta) {
                var array = eval(respuesta)
                $('#clave1').html(array[0]);
                $('#clave').html(array[1]);
              },
              error: function(xhr, status) {
                  alert("error");
                  alert(xhr);
              },
            });
          }
        }
        //modal autorizar incidencias
        $('#modal-pagar').on('show.bs.modal', function(e) {
          var id_registro = $(e.relatedTarget).data().id;
          var url = "consulta_datos_modal.php"; // El script a dónde se realizará la petición.
            $.ajax({
              type: "POST",
              url: url,
              data: {id_registro:id_registro}, // Adjuntar los campos del formulario enviado.
              success: function(respuesta)
              {
                var array = eval(respuesta);
                $('#Nombre').html(array[0]);
                $('#incidenciaA').val(array[4]);
                $('#id_registroO').val(array[1]);
                $('#accionN').val(array[2]);
                $('#comentarioO').val(array[3]);
                $("#fecha").val(array[5]);
              }
            });
        });
        $('#btn-aceptar').click(function(){
          var id_registro= $('#id_registroO').val();
          var decision =$('#decisionN').val();
          var comentario_fin =$('#comentario_finN').val();
            var url = "autorizacion.php";
            $.ajax({
              type: "POST",
              url: url,
              data:{ id_registro:id_registro, 'decision':decision,'comentario_fin':comentario_fin},
              success: function(respuesta) {
                if($('#decisionN').val().length == 0){
                  alertify.error("Verifica Campos");
                }else if($('#comentario_finN').val().length ==0){
                  alertify.error("Verifica Campos");
                }
                else if (respuesta=="ok") {
                  alertify.success("Incidencia Autorizada");
                  cargar_tablaPromotores();
                  cargar_tablaEmpleados();
                  $(":text").val(''); //Limpiar los campos tipo Text
                  $('#decisionN').val("").trigger('change.select2');
                  $('#modal-pagar').modal('hide');
                } else if(respuesta=="ok_actualizado"){
                        alertify.success("Registro Actualizado.");
                      }else{
                  alertify.error("Ha Ocurrido un Error");
                }
              }
            });
        });
        $('#btn-Rechazar').click(function(){
          var id_registro= $('#id_registroO').val();
          var comentario_fin =$('#comentario_finN').val();
            var url = "reechazar.php";
            $.ajax({
              type: "POST",
              url: url,
              data:{ id_registro:id_registro,'comentario_fin':comentario_fin},
              success: function(respuesta) {
                if($('#comentario_finN').val().length == 0){
                  alertify.error("Verifica Campos");
                }
                else if (respuesta=="ok") {
                  alertify.success("Incidencia Rechazada");
                  $(":text").val(''); //Limpiar los campos tipo Text
                  $('#decisionN').val("").trigger('change.select2');
                  $('#modal-pagar').modal('hide');
                  cargar_tablaEmpleados();
                  cargar_tablaPromotores();
                } else if(respuesta=="ok_actualizado"){
                        alertify.success("Registro Actualizado.");
                      }else{
                  alertify.error("Ha Ocurrido un Error");
                }
              }
            });
        });
        //inicia modal insertar firma desde tabla de registros
        $('#modal-firmar').on('show.bs.modal', function(e) {
          var id_registro = $(e.relatedTarget).data().id;
          var url = "consulta_firma2.php"; // El script a dónde se realizará la petición.
            $.ajax({
              type: "POST",
              url: url,
              data: {id_registro:id_registro}, // Adjuntar los campos del formulario enviado.
              success: function(respuesta)
              {
                var array = eval(respuesta);
                $('#NombrePers').html(array[0]);
                $('#documentoFirma').html(array[1]);
                // $('#clave1').val(array[0]);
                $('#confclave').val(array[2]);
                $('#registro').val(array[4]);
              }
            });
        });
        //termina modal insertar firma desde tabla de registros

        //inicia funcion para insertar la firma desde la tabla
        // $('#btn-Editar').click(function(){
        //   var id_registro= $('#registro').val();
        //   var firma1 =$('#claveFirma').val();
        //   var confirmar =$('#confclave').val();
        //     var url = "agregar_firma.php";
        //     $.ajax({
        //       type: "POST",
        //       url: url,
        //       data:{ id_registro:id_registro, 'firma1':firma1,'confirmar':confirmar},
        //       success: function(respuesta) {
        //         if($('#claveFirma').val().length == 0){
        //           alertify.error("Verifica Campos");
        //         }else if(firma1!=confirmar){
        //           alertify.error("Los datos no coinciden");
        //         }
        //         else if (respuesta=="ok") {
        //           alertify.success("Firma Agregada");
        //           cargar_tablaEmpleados();
        //           $('#modal-firmar').modal('hide');
        //         } else if(respuesta=="ok_actualizado"){
        //                 alertify.success("Registro Actualizado.");
        //               }else{
        //           alertify.error("Ha Ocurrido un Error");
        //         }
        //       }
        //     });
        // });
        //termina funcion para insertar la firma desde la tabla

        //inicia la funcion para imprimir el registro
        function imp_ficha(ide){
          window.open("imprimir.php?id_registro="+ide,"folio","width=320,height=900,menubar=no,titlebar=no");
        }
        function imp_fichaP(id){
          window.open("imprimir.php?id_registro="+id,"folio","width=320,height=900,menubar=no,titlebar=no");
        }
        //termina la funcion para imprimir el registro
        $('.form_datetime').datetimepicker({
          //language:  'fr',
          weekStart: 1,
          todayBtn:  1,
          autoclose: 1,
          todayHighlight: 1,
          startView: 2,
          forceParse: 0,
          showMeridian: 1
        });
        $('.form_date').datetimepicker({
          language:  'es',
          weekStart: 1,
          todayBtn:  1,
          autoclose: 1,
          todayHighlight: 1,
          startView: 2,
          minView: 2,
          forceParse: 0
        });
        $('.form_time').datetimepicker({
          language:  'fr',
          weekStart: 1,
          todayBtn:  1,
          autoclose: 1,
          todayHighlight: 1,
          startView: 1,
          minView: 0,
          maxView: 1,
          forceParse: 0
        });
      </script>
    </body>
  </html>