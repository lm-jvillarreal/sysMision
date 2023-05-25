<?php
  include '../global_seguridad/verificar_sesion.php';
  include '../global_settings/conexion_oracle.php';
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
                <h3 class="box-title">Exámenes</h3>
              </div>
              <div class="box-body">
                <div class="tabbable">
                  <ul class="nav nav-tabs">
                    <li class="active"><a href="#1" data-toggle="tab" id="crear" onclick="ocultar()">Crear exámen</a></li>
                    <li><a href="#2" data-toggle="tab" id="aplicar" onclick="ocultar1()">Aplicar Exámen</a></li>
                    <li><a href="#3" data-toggle="tab" id="calificar" onclick="ocultar2()">Calificaciones por empleado</a></li>
                  </ul>
                  <div class="tab-content">
                    <div class="tab-pane active"id="1">
                      <form method="POST" id="form_datos">
                        <br>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nombre">*Nombre:</label>
                                    <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre del exámen" style="250px">
                                    <input type="hidden" name="id_registro" id="id_registro" value="0">
                                    <input type="text" name="selec" id="selec" value="">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="departamento">*Departamento:</label>
                                    <select name="departamento" id="departamento" class="form-control"onchange="habilitar();">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer text-right">
                            <button type="button" class="btn btn-warning" id="editar" disabled>Seleccionar Códigos</button>
                            <button type="submit" class="btn btn-danger" id="guardar">Guardar</button>
                        </div>
                      </form>
                    </div>
                    <div class="tab-pane"id="2">
                      <form method="POST" id="form_aplicar">
                        <br>
                        <div class="row">
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="empleado">*Nombre:</label>
                              <input type="hidden" name="id_registro" id="id_registro" value="0"><br>
                              <select name="id_empleado" id="id_empleado" class="form-control select2" style="width:270px"></select>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="examen">*Examen:</label>
                              <select name="examen" id="examen" class="form-control select2" style="width:250px">
                                <option value=""></option>
                                <option value="imagen">Imagen</option>
                                <option value="codigo">Código</option>
                                <option value="descripcion">Descripción</option>
                                <option value="mixto">Mixto</option>
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
                      <table id="lista_examenes" class="table table-striped table-bordered" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Nombre</th>
                      <th>Tipo</th>
                      <th>Catalogo</th>
                      <th>Editar</th>
                      <th>Eliminar</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>#</th>
                      <th>Nombre</th>
                      <th>Tipo</th>
                      <th>Catalogo</th>
                      <th>Editar</th>
                      <th>Eliminar</th>
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
          <div class="box box-danger" id="contenedor_tabla2" style="display: none;">
        <div class="box-header">
          <h3 class="box-title">Catálogo de Códigos | Lista de Códigos</h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <div class="table-responsive">
                <form action="" method="POST" id="form_detalle">
                <table id="lista_codigos" class="table table-striped table-bordered" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Código</th>
                      <th>Descripción</th>
                      <th>Seleccionar</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>#</th>
                      <th>Código</th>
                      <th>Descripción</th>
                      <th>Seleccionar</th>
                    </tr>
                  </tfoot>
                </table>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- a partir de esta línea insertar la tabla de examenes aplicados -->
              <!-- /.row -->
          </section>
            <!-- /.content -->
        </div>
          <!-- /.content-wrapper -->
          <?php include 'modal_firma.php'; ?>
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
      //funcion para tomar el nombre de sql
              $(function () {
          $('#id_empleado').select2(
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
        //habilitar el boton para seleccionar los codigos
      function habilitar(){
        $('#editar').removeAttr('disabled');
        cargar_tabla();
        seleccionar_todo();
      }
      function cargar_tabla()
      {
        var id_registro = $('#id_registro').val();
        var departamento   = $('#departamento').val();
    
        $('#lista_codigos thead th').each( function () 
        {
          var title = $(this).text();
          $(this).html( '<input type="text" placeholder="'+title+'" style="width:100%" />' );
        });

        $('#lista_codigos').dataTable().fnDestroy();
        var table = $('#lista_codigos').DataTable
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
                title: 'Efectivos',
                exportOptions: 
                {
                  columns: ':visible'
                }
              },
              {
                extend: 'pdf',
                text: 'Exportar a PDF',
                className: 'btn btn-default',
                title: 'Efectivos',
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
              },
              {
                text: 'Seleccionar Todos',
                action: function (  ) {
                  seleccionar_todo();
                },
                className: 'btn btn-danger',
                counter: 1
              }
            ],
            "ajax": {
              "type": "POST",
              "url": "tabla_codigos.php",
              "dataSrc": "",
              "data":{'id_registro':id_registro,'departamento':departamento},
            },
            "columns": 
            [
              { "data": "#","width":"3%"},
              { "data": "Codigo","width":"5%"},
              { "data": "Descripcion"},
              { "data": "Seleccionar","width":"3%"},
            ]
          }
        );
        table.columns().every( function () 
        {
          var that = this;
          $( 'input', this.header() ).on( 'keyup change', function () 
          {
            if ( that.search() !== this.value ) 
            {
              that
                .search( this.value )
                .draw();
            }
          });
        });
      }
      function seleccionar_todo(){
        var cantidad = document.getElementsByClassName("botones").length;
        for (var i = 1; i <= cantidad; i++) {
          seleccionar(i);
        }
      }
      function seleccionar(numero){
        if($('#boton_'+ numero).hasClass('btn-default')){
          $('#boton_'+ numero).removeClass('btn-default');
          $('#boton_'+ numero).addClass('btn-success');
          $('#selecciona_'+ numero).val('1');
        }else{
          $('#boton_'+ numero).removeClass('btn-success');
          $('#boton_'+ numero).addClass('btn-default');
          $('#selecciona_'+ numero).val('0');
        }
      }
      $(function () {
        $('#departamento').select2({
          placeholder: 'Seleccione una opción',
          lenguage: 'es',
          ajax: { 
            url: "consulta_departamentos.php",
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
      $('#editar').click(function(){
        $('#contenedor_tabla2').show();
        cargar_tabla();
        seleccionar_todo();
      })
      function ocultar(){
        $('#promotoresS').hide();
        $('#empleadosS').show();
      }
      function ocultar1(){
        $('#empleadosS').hide();
        $('#promotoresS').show();
        cargar_tablaPromotores();
      }
      function cargar_tablaEmpleados(){
        $('#lista_incidencias').dataTable().fnDestroy();
        $('#lista_incidencias').DataTable( 
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
              },
              "columns": [
                { "data": "id" },
                { "data": "nombre" },
                { "data": "departamento" },
                { "data": "sucursal" },
                { "data": "incidencia" },
                { "data": "categoria" },
                { "data": "comentario" },
                { "data": "vigilante" },
                { "data": "activo"},
                { "data": "autorizar"},
                { "data": "imprimir"}
              ]
          });
        }
        // cargar_tablaEmpleados();
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
                { "data": "incidencia" },
                { "data": "categoria" },
                { "data": "comentario" },
                { "data": "vigilante" },
                { "data": "activo"},
                { "data": "autorizar"},
                { "data": "imprimir"}
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
                  $(":text").val(''); //Limpiar los campos tipo Text
                  $('#comentario').val("");
                  $('#id_persona').val("").trigger('change.select2'); //limpiar campos select
                  $('#categoria').val("").trigger('change.select2');
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
            },
            messages: {
              id_persona:   "Campo requerido",
              departamento: "Campo requerido",
              incidencia:   "Campo requerido",
	            comentario:   "Campo Requerido",
              sucursal:     "Campo Requerido",
              categoria:    "Campo Requerido",
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
            $('#incidencia').select2({
              placeholder: 'Seleccione una opcion',
              lenguage: 'es',
              //minimumResultsForSearch: Infinity
            ajax: { 
          url: "select_incidencia.php",
          type: "post",
          dataType: 'json',
          delay: 250,
          data: function (params) {
            var categoria= $('#categoria').val();
            return {
              searchTerm: params.term,
              categoria:categoria // search term
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
          $('#incidenciaP').select2({
            placeholder: 'Seleccione una opcion',
            lenguage: 'es',
            //minimumResultsForSearch: Infinity
            ajax: { 
              url: "select_incidencia.php",
              type: "post",
              dataType: 'json',
              delay: 250,
              data: function (params) {
                var categoria= $('#categoriaP').val();
                return {
                  searchTerm: params.term,
                  categoria:categoria // search term
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
          $('#categoria').select2({
            placeholder: 'Seleccione una opcion',
            lenguage: 'es',
            //minimumResultsForSearch: Infinity
            ajax: { 
              url: "select_categoria.php",
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
          $('#categoriaP').select2({
            placeholder: 'Seleccione una opcion',
            lenguage: 'es',
            //minimumResultsForSearch: Infinity
            ajax: { 
              url: "select_categoria.php",
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
            $("#categoriaP").select2("trigger", "select", {
              data: { id: array[3], text: array[4] }
            });
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
    </script>
  </body>
</html>