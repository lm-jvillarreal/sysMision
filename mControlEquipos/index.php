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
                <div id="t_registro" style="">
                  <h3 class="box-title">Registro de Equipos | Terminales</h3>
                </div>
                <div id="t_reporte" style="display: none;">
                  <h3 class="box-title">Reporte | Terminales</h3>
                </div>
                <div class="text-left">
                  <a class="btn btn-danger btn-xs" id="boton_regresar" style="display: none" onclick="regresar()">Regresar</a>
                </div>
              </div>
              <div class="box-body">
                <div id="registro" style="">
                  <form method="POST" id="form_datos">
                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <input type="number" name="id_registro" id="id_registro" value="0" class="hidden">
                          <label for="marca">*Marca</label>
                          <select id="marca" class="form-control" name="marca" style="width: 100%">
                            <option></option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="modelo">*Modelo</label>
                          <select id="modelo" class="form-control" name="modelo" style="width: 100%" onchange="llenar_datos(this.value)"></select>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="numero_serie">*Número de Serie</label>
                          <input type="text" name="numero_serie" id="numero_serie" class="form-control" placeholder="Número de Serie" onchange="crear_cadena(this.value)">
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="llave_banorte">*Llave Banorte</label>
                          <input type="text" name="llave_banorte" id="llave_banorte" class="form-control" placeholder="Llave Banorte" readonly>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="caja">*Caja</label>
                          <select name="id_caja" id="id_caja" style="width: 100%" onchange="usu_sucursal(this.value)"></select>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="tipo">*Tecnología</label>
                          <input type="text" id="tipo" name="tipo" class="form-control" placeholder="Tipo" readonly>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="llave_banorte">*Afiliación</label>
                          <input type="text" id="afiliacion" name="afiliacion" class="form-control" placeholder="Afiliacion" readonly>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="usuario">*Usuario</label>
                          <input type="text" id="usuario_banorte" name="usuario_banorte" class="form-control"placeholder="Usuario" readonly>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="contraseña">*Contraseña</label>
                          <input type="text" id="contraseña" name="contraseña" class="form-control" placeholder="Contraseña" readonly>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="tipo">*Cashback</label>
                          <select id="cashback" name="cashback" class="form-control" style="width: 100%"></select>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="tipo">*Cifrada</label>
                          <select id="cifrada" name="cifrada" class="form-control" style="width: 100%"></select>
                        </div>
                      </div>
                    </div>  
                    <div class="box-footer text-right">
                      <button type="submit" class="btn btn-warning" id="guardar">Guardar</button>
                    </div>
                  </form>
                </div>
                <div id="reporte" style="display:none;">
                  <form method="POST" id="form_reporte">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <input type="number" name="id_caja_reporte" id="id_caja_reporte" value="0" class="hidden">
                          <input type="number" name="id_reporte" id="id_reporte" value="0" class="hidden">
                          <label id="datos"></label>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="caja">*Número de Reporte</label>
                          <input type="text" name="num_reporte" id="num_reporte" class="form-control" placeholder="Número de Reporte">
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="llave_banorte">*Fecha Estimada de Llegada</label>
                          <div class="input-group date form_date" data-date="<?php echo $fecha ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_llegada" data-link-format="yyyy-mm-dd">
                            <input class="form-control" size="16" type="text" value="<?php echo $fecha ?>" readonly id="fecha_llegada" name="fecha_llegada" >
                            <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="">*Falla</label><br>
                          <select name="falla" id="falla" class="form-control select2" style="width:230px">
                            <option value=""></option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="llave_banorte">*Número de Serie</label>
                          <input type="text" id="num_serie" name="num_serie" class="form-control" readonly>
                        </div>
                      </div>
                    </div> 
                    <div class="box-footer text-right">
                      <a class="btn btn-warning" onclick="guardar_reporte();" id="g_reporte">Guardar</a>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="box box-danger" id="tabla_principal">
              <div class="box-header">
                <h3 class="box-title">Proveedores Mantenimiento | Lista</h3>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-12" id="tabla">
                    <div class="table-responsive">
                      <table id="lista_equipos" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>N/S</th>
                            <th>Llave</th>
                            <th>Caja</th>
                            <th>Afiliación</th>
                            <th>Tecnología</th>
                            <th>Editar</th>
                            <th>Eliminar</th>
                            <th>Reporte Falla</th>
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
            <div class="col-md-12" id="tabla2" style="display: none;">
              <div class="table-responsive">
                <table id="historial_equipo" class="table table-striped table-bordered" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th width="5%">#</th>
                      <th># Reporte</th>
                      <th>Fecha Llegada</th>
                      <th>Falla</th>
                      <th># Serie Nueva</th>
                      <th># Serie Anterior</th>
                      <th width="5%">Editar</th>
                      <th width="5%">Eliminar</th>
                      <th width="5%">Actualizar</th>
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
                    </tr>
                  </tbody>  
                </table>
              </div>
            </div>
            <!-- /.row -->
          </section>
          <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <?php include 'modal_cajas.php'; ?>
        <?php include 'modal_act_terminal.php'; ?>
        <?php include '../footer2.php'; ?>
        <!-- Control Sidebar -->
        <!-- /.control-sidebar -->
        <!-- Add the sidebar's background. This div must be placed
        immediately after the control sidebar -->
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
          $('#lista_equipos').dataTable().fnDestroy();
          $('#lista_equipos').DataTable( {
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
              "url": "tabla_equipos.php",
              "dataSrc": "",
              "data" :{'id_sucursal':id_sucursal}
            },
            "columns": [
              { "data": "#" },
              { "data": "Marca" },
              { "data": "Modelo" },
              { "data": "NS" },
              { "data": "Llave" },
              { "data": "Caja" },
              { "data": "Afiliacion" },
              { "data": "Tipo" },
              { "data": "Editar" },
              { "data": "Eliminar" },
              { "data": "Reporte Falla" },
            ]
          });
        }
        function estilo_tablas() {
          var id_sucursal = $('#sucursal_2').val();
          $('#lista_equipos').dataTable().fnDestroy();
          $('#lista_equipos').DataTable( {
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
              "url": "tabla_equipos.php",
              "dataSrc": "",
              "data" :{'id_sucursal':id_sucursal}
            },
            "columns": [
              { "data": "#" },
              { "data": "Marca" },
              { "data": "Modelo" },
              { "data": "NS" },
              { "data": "Llave" },
              { "data": "Caja" },
              { "data": "Afiliacion" },
              { "data": "Tipo" },
              { "data": "Editar" },
              { "data": "Eliminar" },
              { "data": "Reporte Falla" },
            ]
          });
        }
        function estilo_tablas_cajas(){
          $('#lista_cajas').dataTable().fnDestroy();
          $('#lista_cajas').DataTable( {
            'language': {"url": "../plugins/DataTables/Spanish.json"},
              "paging":   true,
              "pageLength" : 5,
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
              "url": "tabla_cajas.php",
              "dataSrc": ""
            },
            "columns": [
              { "data": "#","width":"3%" },
              { "data": "Sucursal" },
              { "data": "Caja","width":"3%" },
              { "data": "Tipo","width":"3%" },
              { "data": "Editar","width":"3%" },
              { "data": "Eliminar","width":"3%" },
            ]
          });
        }
        function estilo_tablas2() {
          var id_caja = $('#id_caja_reporte').val();
          $('#historial_equipo').dataTable().fnDestroy();
          $('#historial_equipo').DataTable( {
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
              "url": "tabla_historial.php",
              "dataSrc": "",
              "data" :{'id_caja':id_caja}
            },
            "columns": [
              { "data": "#" },
              { "data": "# Reporte" },
              { "data": "Fecha Llegada" },
              { "data": "Falla" },
              { "data": "SN" },
              { "data": "SA" },
              { "data": "Editar" },
              { "data": "Eliminar" },
              { "data": "Actualizar" },
            ]
          });
        }
        cargar_tabla();
        $("#guardar").click(function(){
          var url = "insertar_terminal.php"; // El script a dónde se realizará la petición.
          $.ajax({
            type: "POST",
            url: url,
            data: $("#form_datos").serialize(), // Adjuntar los campos del formulario enviado.
            success: function(respuesta)
            {
              if (respuesta=="ok") {
                alertify.success("Registro guardado correctamente");
                $("#form_datos")[0].reset();        
                $("#marca").select2("trigger", "select", {
                  data: { id: '', text:'' }
                });
                $("#modelo").select2("trigger", "select", {
                  data: { id: '', text:'' }
                });
                $("#id_caja").select2("trigger", "select", {
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
        function editar_registro(id){
          $.ajax({
            url: 'editar_registro.php',
            data: '&id='+ id,
            type: "POST",
            success: function(respuesta) {
              var array = eval(respuesta);
              id_marca      = array[0];
              marca         = array[1];
              id_modelo     = array[2];
              modelo        = array[3];
              numero_serie  = array[4];
              llave_banorte = array[5];
              id_caja       = array[6];
              caja          = array[7];
              afiliacion    = array[8];
              usuario       = array[9];
              contrasena    = array[10];
              tipo          = array[11];
              cashback      = array[12];
              cifrada       = array[13];

              $('#id_registro').val(id);

              $('#id_caja').removeAttr('onchange');
              $('#modelo').removeAttr('onchange');

              $("#marca").select2("trigger", "select", {
                data: { id: id_marca, text:marca }
              });

              $("#modelo").select2("trigger", "select", {
                data: { id: id_modelo, text:modelo }
              });

              $("#id_caja").select2("trigger", "select", {
                data: { id: id_caja, text:caja }
              });

              $('#numero_serie').val(numero_serie);
              $('#llave_banorte').val(llave_banorte);
              $('#afiliacion').val(afiliacion);
              $('#usuario_banorte').val(usuario);
              $('#contraseña').val(contrasena);
              $('#tipo').val(tipo);
              if (tipo == "PINPAD"){
                $('#usuario_banorte').removeAttr('readonly');
                $('#contraseña').removeAttr('readonly');
              }else if(tipo == "DUAL-UP"){
                $('#usuario_banorte').attr('readonly', true);
                $('#contraseña').attr('readonly', true);
                $('#afiliacion').removeAttr('readonly');
              }else if(tipo == "GRPS"){
                $('#usuario_banorte').attr('readonly', true);
                $('#contraseña').attr('readonly', true);
                $('#afiliacion').removeAttr('readonly');
              }
              cargar_cashback(cashback);
              cargar_cifrada(cifrada);
              volver();
            }
          });
        }
        function volver(){
          $('#id_caja').attr('onchange',"usu_sucursal(this.value)");
          $('#modelo').attr('onchange',"llenar_datos(this.value)");
        }
        function crear_cadena(cadena){
          cadena_nueva = cadena.replace(/['-]+/g, '');
          $('#llave_banorte').val(cadena_nueva);
        }
        $('#modal-defaultcajas').on('show.bs.modal', function(e) {
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
                estilo_tablas_cajas();
              }
            });
        });
        $("#btn-guardar_caja").click(function(){
      var url = "insertar_caja.php";
        $.ajax({
          url: url,
          type: "POST",
          dateType: "html",
          data: $('#form_datos_caja').serialize(),
          success: function(respuesta) {
            if (respuesta=="ok") {
              alertify.success("Registro guardado Correctamente");
              estilo_tablas_cajas();
              $('#caja_m').val("");
              $('#form_datos_caja')[0].reset();
              $("#sucursal_m").select2("trigger", "select", {
                data: { id: '', text:'' }
              });
              $('#tipo_caja').val('').trigger('change.select2');
            }else if(respuesta == "duplicado"){
              alertify.error("Registro Duplicado");
              $('#caja_m').val("");
              $('#caja_m').focus();
            }else if(respuesta == "vacio"){
              $('#caja_m').focus();
              alertify.error("Verifica Campo");
            }else{
              alertify.error("Ha Ocurrido un Error");
            }
          }
        });
        return false;
    });
    function eliminar_caja(id){
      swal({
        title: "¿Está seguro de eliminar registro?",
        icon: "warning",
        buttons: ["No", "Si"],
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.ajax({
            url: 'eliminar_caja.php',
            data: '&id='+id ,
            type: "POST",
            success: function(respuesta) {
              if(respuesta == "ok"){
                alertify.success('Registro Eliminado');
                estilo_tablas_cajas();
              }
              else{
                alertify.error('Ha Ocurrido un Error');
              }
             }
          });
        } else {
          swal("No se ha eliminado el registro.",{
            icon: "error",
          });
        }
      });
    }
        //modal actualizar terminal
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
                $("#modelo_mc").select2("trigger", "select", {
                  data: { id: array[3], text:array[4] }
                });
                $('#numero_serie_m').val(array[5]);
                $('#id_historico').val(array[6]);
                $('#n_reporte').html(array[7]);
              }
            });
        });
        //boton modal actualizar terminal
        $("#btn-actualizar").click(function(){
          var url = "actualizar_terminal.php";
            $.ajax({
              url: url,
              type: "POST",
              dateType: "html",
              data: $('#form-datos-act').serialize(),
              success: function(respuesta) {
                if (respuesta=="ok") {
                alertify.success("Caja Actualizada Correctamente");
                $('#modal-default').modal('hide');
                estilo_tablas2();
                estilo_tablas();
                }else if(respuesta == "1"){
                  alertify.error("Verifica Numero de Serie");
                }else{
                  alertify.error("Ha Ocurrido un Error");
                }
              }
            });
            return false;
        });
        function reporte(id){
          $('#boton_regresar').show();

          $('#t_registro').hide();
          $('#t_reporte').show();

          $('#registro').hide();
          $('#reporte').show();    

          $('#tabla').hide();
          $('#tabla2').show();

          $('#principal').hide();

          $.ajax({
            url: 'datos.php',
            type: "POST",
            data:{'id':id},
            success: function(respuesta) {
              var array = eval(respuesta);

              $('#datos').html(array[0]);
              $('#num_serie').val(array[1]);
              $('#id_caja_reporte').val(array[2]);
              estilo_tablas2();
            }
          });
        }
        function regresar(){
          $('#boton_regresar').hide();

          $('#t_registro').show();
          $('#t_reporte').hide();

          $('#registro').show();
          $('#reporte').hide(); 

          $('#tabla').show();
          $('#tabla2').hide();

          $('#num_reporte').val("");
          $('#falla').val("");
          $('#num_serie').val("");

        }
        function editar_reporte(id){
          $.ajax({
            url: 'editar_reporte.php',
            data: '&id='+ id,
            type: "POST",
            success: function(respuesta) {
              var array = eval(respuesta);
              num_reporte = array[0];
              fecha       = array[1];
              falla       = array[2];
              num_serie   = array[3];
              id_e        = array[4];

              $('#id_reporte').val(id);

              $('#num_reporte').val(num_reporte);
              $('#fecha_llegada').val(fecha);
              $('#falla').val(falla);
              $('#num_serie').val(num_serie);
            }
          });
        }
        $( document ).ready( function () {
          $( "#form_datos" ).validate( {
            rules: {
              no_serie: "required",
              id_sucursal: "required",
              ubicacion: "required",
              marca: "required",
              modelo: "required",
              tipo: "required",
              capacidad: "required",
              entrada_salida: "required",
              tomacorrientes: "required",
              tiempo_respaldo: "required",
              garantia: "required",
              series: "required"
            },
            messages: {
              no_serie: "Campo requerido",
              id_sucursal: "Campo requerido",
              ubicacion: "Campo requerido",
              marca: "Campo requerido",
              modelo: "Campo requerido",
              tipo: "Campo requerido",
              capacidad: "Campo requerido",
              entrada_salida: "Campo requerido",
              tomacorrientes: "Campo requerido",
              tiempo_respaldo: "Campo requerido",
              garantia: "Campo requerido",
              series: "Campo requerido"
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
        function eliminar(id){
          swal({
            title: "¿Está Seguro de Eliminar Registro?",
            icon: "warning",
            buttons: ["No", "Si"],
            dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
              $.ajax({
                url: 'eliminar_ups.php',
                data: {'id':id} ,
                type: "POST",
                success: function(respuesta) {
                  if(respuesta == "ok"){
                    alertify.success('Registro Eliminado');
                    cargar_tabla();
                  }
                  else{
                    alertify.error('Ha Ocurrido un Error');
                  }
                  }
              });
            }
          });
        }
        $(function () {
          $('#sucursal_m').select2({
            placeholder: 'Seleccione una opcion',
            lenguage: 'es',
            //minimumResultsForSearch: Infinity
            ajax: { 
              url: "combo_sucursales.php",
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
          $('#falla').select2({
            placeholder: 'Seleccione una opción',
            lenguage: 'es',
            ajax: { 
          url: "select_falla_terminal.php",
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
        function editar_caja(id){
      $.ajax({
        url: 'editar_caja.php',
        data: {'id':id},
        type: "POST",
        success: function(respuesta) {
          var array = eval(respuesta);
          $('#id_registro_caja').val(id);
          $('#caja_m').val(array[0]);
          $("#sucursal_m").select2("trigger", "select", {
            data: { id: array[1], text:array[2] }
          });
          $('#tipo_caja').val(array[3]).trigger('change.select2');
        }
      });
    }
        function guardar_reporte() {
      $.ajax({
        type: "POST",
        url: 'guardar_reporte.php',
        data: $("#form_reporte").serialize(), // Adjuntar los campos del formulario enviado.
        success: function(respuesta)
        {
          if (respuesta=="ok") {
            alertify.success("Reporte guardado correctamente");
            estilo_tablas2();
            // $('#form_reporte')[0].reset();
            $('#id_reporte').val("0");
            $('#num_reporte').val("");
            $('#falla').val("");
            $('#num_serie').val("");
          }else if(respuesta == "1"){
            alertify.error("Numero de serie no existe");
          }else{
            alertify.error("Ha ocurrido un error");
          }
        }
      });
    }
        function cargar(){
          var id = 1;
            $.ajax({
              url: 'cargar_ultimo.php',
              data: {'id':id},
              type: "POST",
              success: function(respuesta) {
                var array = eval(respuesta);
                $('#id_sucursal').val(array[0]).trigger('change.select2');
                $('#marca').val(array[1]);
                $('#modelo').val(array[2]);
                $('#tipo').val(array[3]);
                $('#capacidad').val(array[4]);
                $('#entrada_salida').val(array[5]);
                $('#tomacorrientes').val(array[6]);
                $('#tiempo_respaldo').val(array[7]);
                $('#garantia').val(array[8]);
                $('#series').val(array[9]);
              }
            });
        }
        $(function () {
          $('#id_caja').select2({
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
        function editar(id){
            $.ajax({
              url: 'editar_ups.php',
              data: {'id':id},
              type: "POST",
              success: function(respuesta) {
                var array = eval(respuesta);
                $('#id_registro').val(id);
                $('#id_sucursal').val(array[0]).trigger('change.select2');
                $('#marca').val(array[1]);
                $('#modelo').val(array[2]);
                $('#tipo').val(array[3]);
                $('#capacidad').val(array[4]);
                $('#entrada_salida').val(array[5]);
                $('#tomacorrientes').val(array[6]);
                $('#tiempo_respaldo').val(array[7]);
                $('#garantia').val(array[8]);
                $('#series').val(array[9]);
                $('#ubicacion').val(array[10]);
                $('#no_serie').val(array[11]);
              }
            });
        }
        function usu_sucursal(sucursal){
          $.ajax({
            url: 'mostrar_usuario.php',
            data: '&sucursal='+ sucursal,
            type: "POST",
            success: function(respuesta) {
              array = eval(respuesta);
              usuario   = array[0];
              pass      = array[1];
              num_afili = array[2];

              $('#usuario_banorte').val(usuario);
              $('#contraseña').val(pass);
              $('#afiliacion').val(num_afili);
            }
          });
        }
        function cargar_cashback(cashback){
          var opciones,texto;
          for (var i = 1; i <= 2; i++) {
            if(i == 1){
              texto = "Si";
            }
            else{
              texto = "No";
            }
            if (texto == cashback){
              opciones += "<option value='" + texto + "' selected>" + texto + "</option>";  
            }
            else{
              opciones += "<option value='" + texto + "'>" + texto + "</option>";
            }
          }
          $('#cashback').html(opciones).fadeIn();
        }
        function cargar_cifrada(cifrada){
          var opciones,texto;
          for (var i = 1; i <= 2; i++) {
            if(i == 1){
              texto = "Si";
            }
            else{
              texto = "No";
            }
            if (texto == cifrada){
              opciones += "<option value='" + texto + "' selected>" + texto + "</option>";  
            }
            else{
              opciones += "<option value='" + texto + "'>" + texto + "</option>";
            }
          }
          $('#cifrada').html(opciones).fadeIn();
        }
        cargar_cashback();
        cargar_cifrada();
        function llenar_datos(modelo){
          $.ajax({
            url: 'datos2.php',
            data: '&modelo='+ modelo,
            type: "POST",
            success: function(respuesta) {
              array = eval(respuesta);
              tipo   = array[0];

              $('#tipo').val(tipo);

              if (tipo == "PINPAD"){
                $('#usuario_banorte').removeAttr('readonly');
                $('#contraseña').removeAttr('readonly');
              }else if(tipo == "DUAL-UP"){
                $('#usuario_banorte').attr('readonly', true);
                $('#contraseña').attr('readonly', true);
                $('#afiliacion').removeAttr('readonly');
              }else if(tipo == "GRPS"){
                $('#usuario_banorte').attr('readonly', true);
                $('#contraseña').attr('readonly', true);
                $('#afiliacion').removeAttr('readonly');
              }
            }
          });
        }
        $(function () {
          $('#cashback').select2({
            placeholder: 'Seleccione una opcion',
            lenguage: 'es'
          });
          $('#cifrada').select2({
            placeholder: 'Seleccione una opcion',
            lenguage: 'es'
          });
          $('#tipo_caja').select2({
            placeholder: 'Seleccione una opcion',
            lenguage: 'es'
          })
        });
        $(function () {
          $('#modelo').select2({
            placeholder: 'Seleccione una opcion',
            lenguage: 'es',
            //minimumResultsForSearch: Infinity
            ajax: { 
              url: "combo_modelos.php",
              type: "post",
              dataType: 'json',
              delay: 250,
              data: function (params) {
                var marca = $('#marca').val();
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
        $(function () {
          $('#marca').select2({
            placeholder: 'Seleccione una opcion',
            lenguage: 'es',
            //minimumResultsForSearch: Infinity
            ajax: { 
            url: "combos_marcas.php",
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
        function eliminar_equipo(id){
          swal({
            title: "¿Está seguro de eliminar registro?",
            icon: "warning",
            buttons: ["No", "Si"],
            dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
              $.ajax({
                url: 'eliminar_equipo.php',
                data: '&id='+id ,
                type: "POST",
                success: function(respuesta) {
                  if(respuesta == "ok"){
                    alertify.success('Registro Eliminado');
                    estilo_tablas();
                  }
                  else{
                    alertify.error('Ha Ocurrido un Error');
                  }
                }
              });
            } else {
              swal("No se ha eliminado el registro.",{
                icon: "error",
              });
            }
          });
        }
        cargar();
        //modelo modal actualizar terminal
        $(function () {
          $('#modelo_mc').select2({
              placeholder: 'Seleccione una opcion',
              lenguage: 'es',
              //minimumResultsForSearch: Infinity
              ajax: { 
            url: "combo_modelos.php",
            type: "post",
            dataType: 'json',
            delay: 250,
            data: function (params) {
              // var marca = $('#marca_e').val();
              return {
                searchTerm: params.term, // search term
                // marca:marca
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
        //marca modal actualizar terminal
        $(function () {
          $('#marca_mc').select2({
            placeholder: 'Seleccione una opcion',
            lenguage: 'es',
            //minimumResultsForSearch: Infinity
            ajax: { 
          url: "combos_marcas.php",
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
