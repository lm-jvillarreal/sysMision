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
            <div class="box box-danger" <?php echo $solo_lectura?>>
              <div class="box-header">
                <h3 class="box-title">Registro de Equipos | Escáner</h3>
              </div>
              <div class="box-body">
                <form method="POST" id="form_datos">
                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <input type="number" name="id_registro_e" id="id_registro_e" value="0" class="hidden">
                        <label for="marca_e">*Marca</label>
                        <select id="marca_e" class="form-control" name="marca_e" style="width: 100%">
                          <option></option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="modelo_e">*Modelo</label>
                        <select id="modelo_e" class="form-control" name="modelo_e" style="width: 100%"></select>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="serie_e">*Número de Serie</label>
                        <input type="text" name="serie_e" id="serie_e" class="form-control" placeholder="Número de Serie">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="class_no_e">*Class No.</label>
                        <input type="text" name="class_no_e" id="class_no_e" class="form-control" placeholder="Class No.">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="caja">*Caja</label>
                        <select name="id_caja_e" id="id_caja_e" style="width: 100%"></select>
                      </div>
                      <!-- onchange="usu_sucursal(this.value)" -->
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="fecha_fabricacion_e">*Fecha Fabricacion</label>
                        <div class="input-group date form_date" data-date="<?php echo $fecha ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_fabricacion_e" data-link-format="yyyy-mm-dd">
                          <input class="form-control" size="16" type="text" value="<?php echo $fecha ?>" readonly id="fecha_fabricacion_e" name="fecha_fabricacion_e" >
                          <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                          <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="serial_no_e">*Serial No.</label>
                        <input id="serial_no_e" name="serial_no_e" class="form-control" placeholder="Serial No.">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="archivo_e">*Factura PDF</label>
                        <input type="file" id="archivo_e" name="archivo_e" accept="application/pdf">
                      </div>
                    </div>
                  </div> 
                  <div class="box-footer text-right">
                    <button type="submit" class="btn btn-warning" id="guardar">Guardar</button>
                  </div>
                </form>
              </div>
            </div>
            <div class="box box-danger" id="tabla_principal">
              <div class="box-header">
                <h3 class="box-title">Lista de Equipos Existentes</h3>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-12" id="tabla">
                    <div class="table-responsive">
                      <table id="lista_escaner" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Caja</th>
                            <th>Serie</th>
                            <th>Class No.</th>
                            <th>Fecha Fabr.</th>
                            <th>No. Serial</th>
                            <th>Factura</th>
                            <th>Editar</th>
                            <th>Eliminar</th>
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
            <!-- /.row -->
          </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <?php include 'modal_act_terminal.php'; ?>
        <?php include 'modal2.php'; ?>
        <?php include '../footer2.php'; ?>
        <!-- Control Sidebar -->
        <!-- /.control-sidebar -->
        <!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
        <div class="control-sidebar-bg"></div>
      </div>
      <!-- ./wrapper -->
      <?php include '../footer.php';?>
      <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
      <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
      <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
      <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
      <!-- Page script -->
      <script>
        function cargar_tabla() {
          var id_sucursal = $('#sucursal_2').val();
            $('#lista_escaner').dataTable().fnDestroy();
            $('#lista_escaner').DataTable( {
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
                title: 'Control Tiempo',
                exportOptions: {
                  columns: ':visible'
                }
              },
              {
                extend: 'pdf',
                text: 'Exportar a PDF',
                className: 'btn btn-default',
                title: 'Control Tiempo',
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
                "url": "tabla_escaner.php",
                "dataSrc": "",
                "data" :{'id_sucursal':id_sucursal}
              },
              "columns": [
                { "data": "#" },
                { "data": "Marca" },
                { "data": "Modelo" },
                { "data": "Caja" },
                { "data": "Serie" },
                { "data": "Class" },
                { "data": "FF" },
                { "data": "NS" },
                { "data": "Factura" },
                { "data": "Editar" },
                { "data": "Eliminar" }
              ]
            });
        }
        function estilo_tablas() {
          var id_sucursal = $('#sucursal_2').val();
              $('#lista_escaner').dataTable().fnDestroy();
              $('#lista_escaner').DataTable( {
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
                  title: 'Control Tiempo',
                  exportOptions: {
                    columns: ':visible'
                  }
                },
                {
                  extend: 'pdf',
                  text: 'Exportar a PDF',
                  className: 'btn btn-default',
                  title: 'Control Tiempo',
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
                  "url": "tabla_escaner.php",
                  "dataSrc": "",
                  "data" :{'id_sucursal':id_sucursal}
                },
                "columns": [
                  { "data": "#" },
                  { "data": "Marca" },
                  { "data": "Modelo" },
                  { "data": "Caja" },
                  { "data": "Serie" },
                  { "data": "Class" },
                  { "data": "FF" },
                  { "data": "NS" },
                  { "data": "Factura" },
                  { "data": "Editar" },
                  { "data": "Eliminar" }
                ]
          });
        } 
        cargar_tabla();
        $("#guardar").click(function(){
          var url = "insertar_escaner.php"; // El script a dónde se realizará la petición.
            $.ajax({
              type: "POST",
              url: url,
              data: $("#form_datos").serialize(), // Adjuntar los campos del formulario enviado.
              success: function(respuesta)
              {
                if (respuesta=="ok") {
                  alertify.success("Registro guardado correctamente");
                  $("#form_datos")[0].reset();        
                  $("#marca_e").select2("trigger", "select", {
                    data: { id: '', text:'' }
                  });
                  $("#modelo_e").select2("trigger", "select", {
                    data: { id: '', text:'' }
                  });
                  $("#id_caja_e").select2("trigger", "select", {
                    data: { id: '', text:'' }
                  });
                  estilo_tablas();
                }else if(respuesta=="duplicado"){
                  alertify.error("El registro ya existe");
                }else if(respuesta=="vacio"){
                  alertify.error("Verifica Camposs");
                }else {
                  alertify.error("Ha ocurrido un error");
                }
              }
            });
            return false;
        });
        function editar_registro_escaner(id){
          $.ajax({
            url: 'editar_registro_escaner.php',
            data: '&id='+ id,
            type: "POST",
            success: function(respuesta) {
              var array = eval(respuesta);

              $('#id_registro_e').val(id);

              $("#marca_e").select2("trigger", "select", {
                data: { id: array[1], text:array[2] }
              });

              $("#modelo_e").select2("trigger", "select", {
                data: { id: array[3], text:array[4] }
              });

              $("#id_caja_e").select2("trigger", "select", {
                data: { id: array[5], text:array[6] }
              });

              $('#serie_e').val(array[7]);
              $('#class_no_e').val(array[8]);
              $('#fecha_fabricacion_e').val(array[9]);
              $('#serial_no_e').val(array[10]);
            }
          });
        }
        // function volver(){
        //   $('#id_caja_e').attr('onchange',"usu_sucursal(this.value)");
        //   $('#modelo_e').attr('onchange',"llenar_datos(this.value)");
        // }
        $( document ).ready( function () {
          $( "#form_datos" ).validate( {
            rules: {
              marca_e: "required",
                modelo_e: "required",
                serie_e: "required",
                class_no_e: "required",
                fecha_fabricacion_e: "required",
                serial_no_e: "required",
                id_caja_e: "required"
            },
            messages: {
              marca_e: "Campo requerido",
                modelo_e: "Campo requerido",
                serie_e: "Campo requerido",
                class_no_e: "Campo requerido",
                fecha_fabricacion_e: "Campo requerido",
                serial_no_e: "Campo requerido",
                id_caja_e: "Campo requerido"
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
        // function cargar(){
        //   var id = 1;
        //     $.ajax({
        //       url: 'cargar_ultimo.php',
        //       data: {'id':id},
        //       type: "POST",
        //       success: function(respuesta) {
        //         var array = eval(respuesta);
        //         $('#id_sucursal').val(array[0]).trigger('change.select2');
        //         $('#marca_e').val(array[1]);
        //         $('#modelo').val(array[2]);
        //         $('#tipo').val(array[3]);
        //         $('#capacidad').val(array[4]);
        //         $('#entrada_salida').val(array[5]);
        //         $('#tomacorrientes').val(array[6]);
        //         $('#tiempo_respaldo').val(array[7]);
        //         $('#garantia').val(array[8]);
        //         $('#series').val(array[9]);
        //       }
        //     });
        // }
        $(function () {
          $('#id_caja_e').select2({
              placeholder: 'Seleccione una opcion',
              lenguage: 'es',
              //minimumResultsForSearch: Infinity
              ajax: { 
            url: "combo_cajas.php",
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
          $('#modelo_e').select2({
            placeholder: 'Seleccione una opcion',
            lenguage: 'es',
            //minimumResultsForSearch: Infinity
            ajax: { 
          url: "combo_modelos2.php",
          type: "post",
          dataType: 'json',
          delay: 250,
          data: function (params) {
            var marca = $('#marca_e').val();
            return {
              searchTerm: params.term, // search term
              marca:marca
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
        $('#modal-default').on('show.bs.modal', function(e) {
          var id = $(e.relatedTarget).data().id;
          var url = "consulta_datos_modal.php"; // El script a dónde se realizará la petición.
            $.ajax({
              type: "POST",
              url: url,
              data: {id:id}, // Adjuntar los campos del formulario enviado.
              success: function(respuesta)
              {
                var array = eval(respuesta);
                
                $('#d_caja').val(array[0]);
                $("#marca_m").select2("trigger", "select", {
                  data: { id: array[1], text:array[2] }
                });
                $("#modelo_m").select2("trigger", "select", {
                  data: { id: array[3], text:array[4] }
                });
                $('#numero_serie_m').val(array[5]);
                $('#id_historico').val(array[6]);
                $('#n_reporte').html(array[7]);
              }
            });
        });
        $(function () {
          $('#marca_e').select2({
            placeholder: 'Seleccione una opcion',
            lenguage: 'es',
            //minimumResultsForSearch: Infinity
            ajax: { 
            url: "combos_marcas_escaner.php",
            type: "post",
            dataType: 'json',
            delay: 250,
            data: function (params) {
              var equipo = $('#equipo').val();
              return {
                searchTerm: params.term, // search term
                equipo: equipo
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
        $(":file").filestyle('buttonText', 'Seleccionar');
        $(":file").filestyle('size', 'sm');
        $(":file").filestyle('input', true);
        $(":file").filestyle('disabled', false);
        // cargar();
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
