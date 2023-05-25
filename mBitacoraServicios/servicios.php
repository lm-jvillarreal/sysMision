<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set('America/Monterrey');
  $fecha      = date('Y-m-d');
  $nuevafecha = strtotime('+1 day', strtotime($fecha));
  $nuevafecha = date('Y-m-d', $nuevafecha);
  $hora       = date('h:i:s');
  $prim_dia   = date('Y-m-01');
?>
<!DOCTYPE html>
<html>

<head>
  <?php include '../head.php'; ?>
  <link href="../plugins/bootstrap-fileinput-master/css/fileinput.css" media="all" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="../plugins/VenoBox-master/venobox/venobox.css" type="text/css" media="screen" />
</head>

<body class="hold-transition skin-red sidebar-mini">
  <div class="wrapper">

    <header class="main-header">
      <?php include '../header.php'; ?>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <?php include 'menuV2.php'; ?>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <!-- Main content -->
      <section class="content">
        <div class="box box-danger" <?php echo $solo_lectura ?>>
          <div class="box-header">
            <h3 class="box-title">Bitacora de Servicios | Pago de Servicios</h3>
            <!-- <button onclick="limpiar_filtro()">Limpiar</button> -->
          </div>
          <div class="box-body">
            <form method="POST" id="form_datos" enctype="multipart/form-data">
              <input type="text" id="id_pago" name="id_pago" value="0" class="hidden">
              <div class="row">
                <div class="col-md-12">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="fecha">*Descripcion:</label>
                      <input type="text" class="form-control" id="descripcion" name="descripcion" placeholder="Descripcion del Pago">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="fecha">*Sucursal:</label>
                      <select name="sucursal" id="sucursal" class="form-control" style="width: 100%"></select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="fecha">*Monto Total:</label>
                      <div class="input-group">
                        <div class="input-group-addon">$</div>
                        <input type="text" class="form-control" id="gasto_total" name="gasto_total" value="0" readonly>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="box-footer text-right">
                <button type="submit" class="btn btn-warning" id="guardar">Guardar</button>
              </div>
            </form>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Bitacora de Servicios | Lista de Servicios</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
            </div>
          </div>
          <div class="box-body" onmouseover="efecto();">
            <div class="table-responsive">
              <table id="lista_servicios" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Proveedor</th>
                    <th>Encargado</th>
                    <th>Fecha</th>
                    <th>Gasto</th>
                    <th>Sucursal</th>
                    <!-- <th>Img.</th> -->
                    <th>Comentario</th>
                    <th>Selec.</th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
          <div class="box-body">
            <form method="POST" id="form_datoss" action="generar_lista.php">
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="fecha_inicio">*Fecha Inicio: </label>
                    <div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="fecha_inicio" data-link-format="yyyy-mm-dd">
                      <input class="form-control" size="16" type="text" value="<?php echo $prim_dia?>" id="fecha_inicio" name="fecha_inicio">
                      <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                      <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="fecha_final">*Fecha final:</label>
                    <div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="fecha_final" data-link-format="yyyy-mm-dd">
                      <input class="form-control" size="16" type="text" value="<?php echo $fecha?>" id="fecha_final" name="fecha_final">
                      <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                      <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="box-footer text-right">
                <a class="btn btn-warning" id= "btn-generar" >Mostrar Datos</a>
                <br>
              </div>
            </form>
            <div class="table-responsive">
              <table id="lista_servicios_guardados" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th width="5%">#</th>
                    <th>Descripcion</th>
                    <th width="16%">Monto Total</th>
                    <th width="16%">Sucursal</th>
                    <th width="16%">Fecha</th>
                    <th width="5%">Acciones</th>
                  </tr>
                </thead>
                <tfooter>
                  <tr>
                    <th width="5%">#</th>
                    <th>Descripcion</th>
                    <th width="16%">Monto Total</th>
                    <th width="16%">Sucursal</th>
                    <th width="16%">Fecha</th>
                    <th width="5%">Acciones</th>
                  </tr>
                </tfooter>
              </table>
            </div>
          </div>
          <div class="box-footer"></div>
        </div>
        <!-- /.row -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php include '../footer2.php'; ?>
    <!-- Control Sidebar -->
    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
  </div>
  <!-- ./wrapper -->
  <?php include '../footer.php';
  include 'modal_comentario.php';
  include 'modal_rublo.php'; ?>
  <!-- Page script -->
  <script src="../plugins/bootstrap-fileinput-master/js/plugins/piexif.js" type="text/javascript"></script>
  <script src="../plugins/bootstrap-fileinput-master/js/plugins/sortable.js" type="text/javascript"></script>
  <script src="../plugins/bootstrap-fileinput-master/js/fileinput.js" type="text/javascript"></script>
  <script src="../plugins/bootstrap-fileinput-master/js/locales/fr.js" type="text/javascript"></script>
  <script src="../plugins/bootstrap-fileinput-master/js/locales/es.js" type="text/javascript"></script>
  <script src="../plugins/bootstrap-fileinput-master/themes/fa/theme.js" type="text/javascript"></script>
  <script src="../plugins/bootstrap-fileinput-master/themes/explorer-fa/theme.js" type="text/javascript"></script>
  <script src='../plugins/VenoBox-master/venobox/venobox.min.js'></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
  <script>
    function limpiar_filtro() {
      var table = $('#lista_servicios').DataTable();
      table
        .search('')
        .columns().search('')
        .draw();
    }
    $("#btn-generar").click(function() {
		  cargar_tabla2();
      //mostrar_datos();
     
  })
    function efecto() {
      var test = $('.venobox').venobox();
      // close current item clicking on .closeme
      $(document).on('click', '.closeme', function(e) {
        test.VBclose();
      });
      // go to next item in gallery clicking on .next
      $(document).on('click', '.next', function(e) {
        test.VBnext();
      });
      // go to previous item in gallery clicking on .previous
      $(document).on('click', '.previous', function(e) {
        test.VBprev();
      });
    }

    function cargar_tabla2(filtro) {
      var fecha_inicial = $("#fecha_inicio").val();
			var fecha_final = $("#fecha_final").val();
      $('#lista_servicios_guardados').dataTable().fnDestroy();
      $('#lista_servicios_guardados').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        'paging': false,
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
            title: 'Bitacora Servicios',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'pdf',
            text: 'Exportar a PDF',
            className: 'btn btn-default',
            title: 'Bitacora Servicios',
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
            text: 'Registros Propios',
            action: function() {
              cargar_tabla2(1);
            },
            className: 'btn btn-default',
            counter: 1
          },
          {
            text: 'Registros Todos',
            action: function() {
              cargar_tabla2(0);
            },
            className: 'btn btn-default',
            counter: 1
          }
        ],
        "ajax": {
          "type": "POST",
          "url": "tabla3.php",
          "dataSrc": "",
          "data": {
            filtro: filtro,
            fecha_final: fecha_final,
					  fecha_inicial: fecha_inicial
          },
        },
        "columns": [{
            "data": "#"
          },
          {
            "data": "Descripcion"
          },
          {
            "data": "MontoTotal",
            "width": "5%"
          },
          {
            "data": "Sucursal",
            "width": "5%"
          },
          {
            "data": "Fecha",
            "width": "5%"
          },
          {
            "data": "Acciones",
            "width": "13%"
          }
        ]
      });
    }

    function seleccionar_todos() {
      var cantidad = $('.selec').length;
      for (var i = 1; i <= cantidad; i++) {
        seleccionar(i);
      }
    }

    function cargar_tabla(filtro) {
      var id_pago = $('#id_pago').val();
      $('#lista_servicios').dataTable().fnDestroy();
      $('#lista_servicios').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        'paging': false,
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
            title: 'Bitacora Servicios',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'pdf',
            text: 'Exportar a PDF',
            className: 'btn btn-default',
            title: 'Bitacora Servicios',
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
            action: function() {
              seleccionar_todos();
            },
            className: 'btn btn-default',
            counter: 1
          },
          {
            text: 'Registros Propios',
            action: function() {
              cargar_tabla(1);
            },
            className: 'btn btn-default',
            counter: 1
          },
          {
            text: 'Registros Todos',
            action: function() {
              cargar_tabla(0);
            },
            className: 'btn btn-default',
            counter: 1
          }
        ],
        "ajax": {
          "type": "POST",
          "url": "tabla2.php",
          "dataSrc": "",
          "data": {
            'id_pago': id_pago,
            'filtro': filtro
          },
        },
        "columns": [{
            "data": "#",
            "width": '1%'
          },
          {
            "data": "Proveedor",
            "width": '15%'
          },
          {
            "data": "Encargado",
            "width": '10%'
          },
          {
            "data": "Fecha",
            "width": '8%'
          },
          {
            "data": "Gasto",
            "width": '5%'
          },
          {
            "data": "Sucursal",
            "width": '5%'
          },
          {
            "data": "Comentario"
          },
          {
            "data": "Seleccionar",
            "width": '9%'
          }
        ]
      });
    }

    function editar_pago(id_pago) {
      $.ajax({
        type: "POST",
        url: 'consulta_datos_pago.php',
        data: {
          'id_pago': id_pago
        }, // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          var array = eval(respuesta);
          $('#id_pago').val(id_pago);
          $('#descripcion').val(array[0]);
          $('#gasto_total').val(array[1]);
          $("#sucursal").select2("trigger", "select", {
            data: {
              id: array[2],
              text: array[3]
            }
          });
          cargar_tabla(0);
        }
      });
    }

    function eliminar_pago(id_pago) {
      swal({
          title: "¿Está seguro de eliminar registro?",
          icon: "warning",
          buttons: ["No", "Si"],
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            $.ajax({
              url: 'eliminar_pago.php',
              data: '&id_pago=' + id_pago,
              type: "POST",
              success: function(respuesta) {
                if (respuesta = "ok") {
                  alertify.success("Registro Eliminado Correctamente");
                  cargar_tabla(0);
                  cargar_tabla2(0);
                } else {
                  alertify.error("Ha Ocurrido un Error");
                }
              }
            });
          }
        });
    }

    function eliminar_detalle(id_detalle) {
      swal({
          title: "¿Está seguro de eliminar registro?",
          icon: "warning",
          buttons: ["No", "Si"],
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            $.ajax({
              url: 'eliminar_detalle.php',
              data: '&id_detalle=' + id_detalle,
              type: "POST",
              success: function(respuesta) {
                if (respuesta = "ok") {
                  alertify.success("Registro Eliminado Correctamente");
                  cargar_tabla(0);
                } else {
                  alertify.error("Ha Ocurrido un Error");
                }
              }
            });
          }
        });
    }

    function seleccionar(numero) {
      //alert(numero);
      if ($('#boton_' + numero).hasClass('btn-default')) {
        $('#boton_' + numero).removeClass('btn-default');
        $('#boton_' + numero).addClass('btn-success');
        $('#selecciona_' + numero).val('1');
        var gasto_total = $('#gasto_total').val();
        var gasto = $('#gasto_' + numero).val();
        var nuevo_gasto = parseFloat(gasto_total) + parseFloat(gasto);
        // alert(nuevo_gasto);
        $('#gasto_total').val(nuevo_gasto);
      } else {
        $('#boton_' + numero).removeClass('btn-success');
        $('#boton_' + numero).addClass('btn-default');
        $('#selecciona_' + numero).val('0');

        var gasto_total = $('#gasto_total').val();
        var gasto = $('#gasto_' + numero).val();
        var nuevo_gasto = parseFloat(gasto_total) - parseFloat(gasto);
        $('#gasto_total').val(nuevo_gasto);
      }
    }
    $('#modal-default1').on('show.bs.modal', function(e) {
      var id = $(e.relatedTarget).data().id;
      var url = "consulta_datos_modal.php"; // El script a dónde se realizará la petición.
      $.ajax({
        type: "POST",
        url: url,
        data: {
          id: id
        }, // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          $('#comentario_modal').html(respuesta);
        }
      });
    });
    cargar_tabla(0);
    cargar_tabla2(0);
    $.validator.setDefaults({
      submitHandler: function() {
        limpiar_filtro();
        var f = $(this);
        var formData = new FormData(document.getElementById("form_datos"));
        formData.append("dato", "valor");
        //formData.append(f.attr("name"), $(this)[0].files[0]);
        $.ajax({
            type: "POST",
            url: 'guardar2.php',
            dataType: "html",
            data: formData,
            cache: false,
            contentType: false,
            processData: false
          })
          .done(function(res) {
            if (res == "ok") {
              alertify.success("Registros Guardados Correctamente");
              $("#sucursal").select2("trigger", "select", {
                data: {
                  id: '',
                  text: ''
                }
              });
              $('#form_datos')[0].reset();
              cargar_tabla(0);
              cargar_tabla2(0);
            } else if (res == "vacio") {
              alertify.error("Selecciona un Servicio");
            } else {
              alertify.error("Ha Ocurrido un Error");
            }
          });
        // Evitar ejecutar el submit del formulario.
        return false;
      }
    });
    $('#sucursal').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity
      ajax: {
        url: "consulta_sucursales.php",
        type: "post",
        dataType: 'json',
        delay: 250,
        data: function(params) {
          return {
            searchTerm: params.term // search term
          };
        },
        processResults: function(response) {
          return {
            results: response
          };
        },
        cache: true
      }
    })
    $(document).ready(function() {
      $("#form_datos").validate({
        rules: {
          descripcion: "required",
          gasto_total: "required",
          sucursal: "required"
        },
        messages: {
          descripcion: "Campo requerido",
          gasto_total: "Campo requerido",
          sucursal: "Campo requerido"
        },
        errorElement: "em",
        errorPlacement: function(error, element) {
          // Add the `help-block` class to the error element
          error.addClass("help-block");
          if (element.prop("type") === "checkbox") {
            error.insertAfter(element.parent("label"));
          } else {
            error.insertAfter(element);
          }
        },
        highlight: function(element, errorClass, validClass) {
          $(element).parents(".col-md-3").addClass("has-error").removeClass("has-success");
          $(element).parents(".col-md-4").addClass("has-error").removeClass("has-success");
          $(element).parents(".col-md-6").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function(element, errorClass, validClass) {
          $(element).parents(".col-md-3").addClass("has-success").removeClass("has-error");
          $(element).parents(".col-md-4").addClass("has-success").removeClass("has-error");
          $(element).parents(".col-md-6").addClass("has-success").removeClass("has-error");
        }
      });
    });
    $('.form_datetime').datetimepicker({
      //language:  'fr',
      weekStart: 1,
      todayBtn: 1,
      autoclose: 1,
      todayHighlight: 1,
      startView: 2,
      forceParse: 0,
      showMeridian: 1
    });
    $('.form_date').datetimepicker({
      language: 'es',
      weekStart: 1,
      todayBtn: 1,
      autoclose: 1,
      todayHighlight: 1,
      startView: 2,
      minView: 2,
      forceParse: 0
    });
    $('.form_time').datetimepicker({
      language: 'fr',
      weekStart: 1,
      todayBtn: 1,
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