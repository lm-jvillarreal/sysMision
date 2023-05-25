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
        <div class="box box-danger" <?php echo $solo_lectura; ?>>
          <div class="box-header">
            <h3 class="box-title">Materiales | Catálogo</h3>
          </div>
          <div class="box-body">
            <form method="POST" id="form_datos">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="nombre">*Nombre:</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre del material">
                    <input type="hidden" name="id_registro" id="id_registro" value="0">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="descripcion">*Descripcion:</label>
                    <input type="text" name="descripcion" id="descripcion" class="form-control" placeholder="Descripcion del Material">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="id_sucursal">*Bodega</label>
                    <select name="id_sucursal" id="id_sucursal" class="form-control"></select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="">*Tipo Bodega:</label>
                    <select name="t_bodega" id="t_bodega" class="form-control"></select>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="">*Existencia:</label>
                    <input type="text" name="existencia" id="existencia" class="form-control" placeholder="Existencia">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="">*Tipo Proveedor:</label>
                    <button type="button" class="btn btn-danger boton">Proveedor de INFOFIN</button>
                    <input type="hidden" name="tipo" id="tipo" class="form-control" value="1">
                  </div>
                </div>
                <div class="col-md-4" style="display: none;" id="otro">
                  <div class="form-group">
                    <label for="">*Proveedor:</label>
                    <input type="text" name="proveedor" id="proveedor" class="form-control" placeholder="Nombre del Proveedor">
                  </div>
                </div>
                <div class="col-md-4" id="infofin">
                  <div class="form-group">
                    <label for="">*Proveedor INFOFIN:</label>
                    <select name="id_proveedor" id="id_proveedor" class="form-control"></select>
                  </div>
                </div>
              </div>
          </div>
          <div class="box-footer text-right">
            <button type="submit" class="btn btn-warning" id="guardar">Guardar</button>
          </div>
          </form>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Materiales | Lista de Materiales</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table id="lista_materiales" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Proveedor</th>
                        <th>Bodega</th>
                        <th>Existencia</th>
                        <th>Pedir</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Proveedor</th>
                        <th>Bodega</th>
                        <th>Existencia</th>
                        <th>Pedir</th>
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
        <!-- /.row -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php include '../footer2.php'; ?>

    <!-- Control Sidebar -->

    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
  </div>
  <!-- ./wrapper -->

  <?php include '../footer.php';
  include 'modal.php';
  include 'modal_material_pedido.php';
  include 'modal_bodega.php'; ?>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
  <!-- Page script -->
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
  <script src="https://code.highcharts.com/highcharts.js"></script>
  <script>
    function cargar_tabla() {
      $('#lista_materiales').dataTable().fnDestroy();
      $('#lista_materiales thead th').each(function() {
        var title = $(this).text();
        $(this).html('<input type="text" placeholder="' + title + '" style="width:100%" />');
      });
      var table = $('#lista_materiales').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": false,
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
            title: 'Catalogo Materiales',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'pdf',
            text: 'Exportar a PDF',
            className: 'btn btn-default',
            title: 'Catalogo Materiales',
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
          "url": "tabla_materiales.php",
          "dataSrc": ""
        },
        "columns": [{
            "data": "#",
            "width": "2%"
          },
          {
            "data": "Nombre"
          },
          {
            "data": "Proveedor"
          },
          {
            "data": "TBodega"
          },
          {
            "data": "Existencia",
            "width": "5%"
          },
          {
            "data": "Pedir",
            "width": "5%"
          },
          {
            "data": "Editar",
            "width": "5%"
          },
          {
            "data": "Eliminar",
            "width": "5%"
          }
        ]
      });
      table.columns().every(function() {
        var that = this;
        $('input', this.header()).on('keyup change', function() {
          if (that.search() !== this.value) {
            that
              .search(this.value)
              .draw();
          }
        });
      });
    }
    $(function() {
      cargar_tabla();
    })
    $.validator.setDefaults({
      submitHandler: function() {
        var url = "insertar_material.php"; // El script a dónde se realizará la petición.
        $.ajax({
          type: "POST",
          url: url,
          data: $("#form_datos").serialize(), // Adjuntar los campos del formulario enviado.
          success: function(respuesta) {
            if (respuesta == "ok") {
              alertify.success("Registro guardado correctamente");
              $('#form_datos')[0].reset();
              $('.boton').removeClass('btn-warning');
              $('.boton').addClass('btn-danger');
              $('.boton').html('Proveedor de INFOFIN');
              $('#tipo').val('1');
              $('#infofin').show();
              $('#otro').hide();
              $("#id_proveedor").select2("trigger", "select", {
                data: {
                  id: '',
                  text: ''
                }
              });
              $("#t_bodega").select2("trigger", "select", {
                data: {
                  id: '',
                  text: ''
                }
              });
              $('#id_registro').val("0");
              cargar_tabla();
            } else if (respuesta == "duplicado") {
              alertify.error("El registro ya existe");
            } else {
              alertify.error("Ha ocurrido un error");
            }
          }
        });
        // Evitar ejecutar el submit del formulario.
        return false;
      }
    });
    $(document).ready(function() {
      $("#form_datos").validate({
        rules: {
          nombre: "required",
          descripcion: "required",
          id_sucursal: "required",
          existencia: "required",
          t_bodega: "required"

        },
        messages: {
          nombre: "Campo requerido",
          descripcion: "Campo requerido",
          id_sucursal: "Campo requerido",
          existencia: "Campo requerido",
          t_bodega: "Campo requerido"
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
    $('#id_proveedor').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity
      ajax: {
        url: "combo_proveedores.php",
        type: "post",
        dataType: 'json',
        delay: 250,
        data: function(params) {
          return {
            searchTerm: params.term
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
    $('#id_sucursal').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity
      ajax: {
        url: "combo_sucursales.php",
        type: "post",
        dataType: 'json',
        delay: 250,
        data: function(params) {
          return {
            searchTerm: params.term
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
    $('#encargadotb').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity
      ajax: {
        url: "combo_usuarios.php",
        type: "post",
        dataType: 'json',
        delay: 250,
        data: function(params) {
          var id_bodega = $('#id_registrotb').val();
          return {
            searchTerm: params.term,
            id_bodega: id_bodega
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
    $('.boton').click(function() {
      if ($(this).hasClass('btn-danger')) {
        $(this).removeClass('btn-danger');
        $(this).addClass('btn-warning');
        $(this).html('Otro Proveedor');
        $('#tipo').val('2');
        $('#infofin').hide();
        $('#otro').show();
      } else {
        $(this).removeClass('btn-warning');
        $(this).addClass('btn-danger');
        $(this).html('Proveedor de INFOFIN');
        $('#tipo').val('1');
        $('#infofin').show();
        $('#otro').hide();
      }
    })

    function editar_material(id) {
      $.ajax({
        type: "POST",
        url: 'consulta_datos_material.php',
        data: {
          'id': id
        }, // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          var array = eval(respuesta);
          $('#id_registro').val(id);
          $('#nombre').val(array[0]);
          $('#descripcion').val(array[1]);
          $("#id_sucursal").select2("trigger", "select", {
            data: {
              id: array[2],
              text: array[3]
            }
          });
          $('#existencia').val(array[4]);
          $('#tipo').val(array[5]);
          $("#t_bodega").select2("trigger", "select", {
            data: {
              id: array[8],
              text: array[9]
            }
          });
          if (array[5] == 1) {
            if ($('.boton').hasClass('btn-danger')) {} else {
              $('.boton').removeClass('btn-warning');
              $('.boton').addClass('btn-danger');
              $('.boton').html('Proveedor de INFOFIN');
              $('#tipo').val('1');
              $('#infofin').show();
              $('#otro').hide();
            }
            $("#id_proveedor").select2("trigger", "select", {
              data: {
                id: array[6],
                text: array[7]
              }
            });
          } else {
            if ($('.boton').hasClass('btn-warning')) {} else {
              $('.boton').removeClass('btn-danger');
              $('.boton').addClass('btn-warning');
              $('.boton').html('Otro Proveedor');
              $('#tipo').val('2');
              $('#infofin').hide();
              $('#otro').show();
              $('#proveedor').val(array[6]);
            }
          }
        }
      });
      // Evitar ejecutar el submit del formulario.
      return false;
    }

    function eliminar_material(id) {
      swal({
          title: "¿Está seguro de eliminar registro?",
          icon: "warning",
          buttons: ["No", "Si"],
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            $.ajax({
              url: 'eliminar_material.php',
              data: {
                'id': id
              },
              type: "POST",
              success: function(respuesta) {
                if (respuesta = "ok") {
                  alertify.success("Registro Eliminado Correctamente");
                  cargar_tabla();
                } else {
                  alertify.error("Ha Ocurrido un Error");
                }
              }
            });
          }
        });
    }

    function activar(numero) {
      if ($('#nueva_existencia' + numero).hasClass('hidden')) {
        $('#nueva_existencia' + numero).removeClass('hidden');
      } else {
        $('#nueva_existencia' + numero).addClass('hidden');
      }
    }

    function actualizar_existencia(id, valor) {
      if (valor == "" || valor == 0) {
        alertify.error("Verifica la cantidad");
        return false;
      }
      var url = "actualizar_existencia.php"; // El script a dónde se realizará la petición.
      $.ajax({
        type: "POST",
        url: url,
        data: {
          'valor': valor,
          'id': id
        }, // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          if (respuesta == "ok") {
            cargar_tabla();
            alertify.success("Se ha Actualizado la Existencia");
          } else {
            alertify.error("Ha ocurrido un error");
          }
        }
      });
    }
    $('#t_bodega').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity
      ajax: {
        url: "combo_tipo_bodega.php",
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
    $('#material').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity
      ajax: {
        url: "combo_materiales.php",
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

    function llenar(id_material) {
      $.ajax({
        type: "POST",
        url: 'data.php',
        data: {
          'id_material': id_material
        }, // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          if (respuesta == "0") {
            $('#cantidad').attr('placeholder', respuesta);
            alertify.error("No hay Piezas Disponibles");
          } else {
            $('#cantidad').attr('placeholder', respuesta);
          }
        }
      });
    }
    $('#modal-usar').on('show.bs.modal', function(e) {
      $("#material").select2("trigger", "select", {
        data: {
          id: '',
          text: ''
        }
      });
      $('#cantidad').val("");
      $('#guardar_modal').attr('disabled', true);
    });

    function verificar(cantidad) {
      var limite = document.querySelector('#cantidad');
      if (cantidad == 0 || cantidad == "") {
        alertify.error("Ingresa un numero mayor a 0");
        $('#guardar_modal').attr('disabled', true);
      } else if (cantidad <= limite.placeholder) {
        $('#guardar_modal').attr('disabled', false);
      } else {
        alertify.error("No tienes piezas suficientes");
        $('#guardar_modal').attr('disabled', true);
      }
    }
    $("#guardar_modal").click(function() {
      var material = $('#material').val();
      var cantidad = $('#cantidad').val();
      var url = "usar_material.php"; // El script a dónde se realizará la petición.
      $.ajax({
        type: "POST",
        url: url,
        data: {
          'material': material,
          'cantidad': cantidad
        }, // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          if (respuesta == "ok") {
            alertify.success("Se ha descontado de existencia correctamente");
            $("#material").select2("trigger", "select", {
              data: {
                id: '',
                text: ''
              }
            });
            $('#cantidad').val("0");
            $('#guardar_modal').attr('disabled', true);
            cargar_tabla();
            $('#modal-usar').modal('hide');
          } else {
            alertify.error("Ha ocurrido un error");
          }
        }
      });
      return false;
    });

    function pedir(id, dato) {
      $.ajax({
        url: 'pedir_material.php',
        data: {
          'id': id,
          'dato': dato
        },
        type: "POST",
        success: function(respuesta) {
          if (respuesta == "ok") {
            alertify.success("Material Pedido Correctamente");
            cargar_tabla();
            cargar_tabla_modal();
          } else if (respuesta == "cancelado") {
            alertify.error("Cancelado Correctamente");
            cargar_tabla();
            cargar_tabla_modal();
          } else {
            alertify.success("Entregado a Sistemas");
            cargar_tabla();
            cargar_tabla_modal();
          }
        }
      });
    }

    function cargar_tabla_modal() {
      $('#lista_materiales_pedidos').dataTable().fnDestroy();
      $('#lista_materiales_pedidos').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },"paging": false,
        "order": [
          [0, "asc"]
        ],
        "searching": true,
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
						title: 'Modulos-Lista',
						exportOptions: {
							columns: ':visible'
						}
					},
					{
						extend: 'pdf',
						text: 'Exportar a PDF',
						className: 'btn btn-default',
						title: 'Modulos-Lista',
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
          "url": "tabla_materiales_pedidos.php",
          "dataSrc": ""
        },
        "columns": [{
            "data": "#",
            "width": "2%"
          },
          {
            "data": "Nombre"
          },
          {
            "data": "Cantidad",
            "width": "5%"
          },
          {
            "data": "Status",
            "width": "5%"
          },
          {
            "data": "Cancelar",
            "width": "5%"
          }
        ]
      });
    }
    $('#modal-default').on('show.bs.modal', function(e) {
      cargar_tabla_modal();
    });
    $('#modal-bodega').on('show.bs.modal', function(e) {
      $('#editar').hide();
      $('#insertar').show();
      cargar_tabla_tb();
      $('#form_datos')[0].reset();
      if ($('.tipo').hasClass('btn-danger')) {} else {
        $('.tipo').removeClass('btn-success');
        $('.tipo').addClass('btn-danger');
        $('.tipo').html('Perfil');
        $('#divtb2').hide();
        $('#divtb').show();
        $('#tipotb').val("1");
      }
    });
    // $('.tipo').click(function(){
    //   if($(this).hasClass('btn-danger')){
    //     $(this).removeClass('btn-danger');
    //     $(this).addClass('btn-success');
    //     $(this).html('Usuario');
    //     $('#divtb').hide();
    //     $('#divtb2').show();
    //     $('#tipotb').val("2");
    //   }else{
    //     $(this).removeClass('btn-success');
    //     $(this).addClass('btn-danger');
    //     $(this).html('Perfil');
    //     $('#divtb2').hide();
    //     $('#divtb').show();
    //     $('#tipotb').val("1");
    //   }
    // })
    $('#usuariotb').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity
      ajax: {
        url: "combo_usuarios2.php",
        type: "post",
        dataType: 'json',
        delay: 250,
        data: function(params) {
          var id_bodega = $('#id_registrotb').val();
          return {
            searchTerm: params.term, // search term
            id_bodega: id_bodega
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
    $('#perfiltb').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity
      ajax: {
        url: "combo_perfiles.php",
        type: "post",
        dataType: 'json',
        delay: 250,
        data: function(params) {
          var id_bodega = $('#id_registrotb').val();
          return {
            searchTerm: params.term, // search term
            id_bodega: id_bodega
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
    $('#guardartb').click(function() {
      var id_bodega = $('#id_registrotb').val();

      if (id_bodega == 0) {
        var nombre = $('#nombretb').val();
        var encargado = $('#encargadotb').val();
        var tipo = $('#tipotb').val();
        if (tipo == 1) {
          var usuario = $('#perfiltb').val();
        } else {
          var usuario = $('#usuariotb').val();
        }
        if (nombre == "" || encargado == "" || usuario == "") {
          alertify.error("Verifica Campos");
          return false;
        }
      }

      $.ajax({
        url: 'guardar_tb.php',
        data: $('#form_tb').serialize(),
        type: "POST",
        success: function(respuesta) {
          if (respuesta == "ok") {
            alertify.success("Registro Guardado Correctamente");
            cargar_tabla();
            cargar_tabla_tb();
            $('#form_tb')[0].reset();

            ///Limpiar opciones de un multiselect
            $('#encargadotb option').each(function(index, option) {
              $(option).remove();
            });
            $('#perfiltb option').each(function(index, option) {
              $(option).remove();
            });
            $('#usuariotb option').each(function(index, option) {
              $(option).remove();
            });
            $('#modal-bodega').modal('hide');
          } else if (respuesta == "act") {
            $('#editar').show();
            $('#insertar').hide();
            cargar_tabla_encargados();
            cargar_tabla_usuarios();
            $('#encargadotb option').each(function(index, option) {
              $(option).remove();
            });
            $('#perfiltb option').each(function(index, option) {
              $(option).remove();
            });
            $('#usuariotb option').each(function(index, option) {
              $(option).remove();
            });
            alertify.success("Registro Actualizado Correctamente");
          } else {
            alertify.error("Ha Ocurrido un Error");
          }
        }
      });
    })

    function cargar_tabla_tb() {
      $('#lista_tipos_bodega').dataTable().fnDestroy();
      $('#lista_tipos_bodega').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": false,
        "order": [
          [0, "asc"]
        ],
        "searching": true,
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
						title: 'Modulos-Lista',
						exportOptions: {
							columns: ':visible'
						}
					},
					{
						extend: 'pdf',
						text: 'Exportar a PDF',
						className: 'btn btn-default',
						title: 'Modulos-Lista',
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
          "url": "tabla_tiposbodega.php",
          "dataSrc": ""
        },
        "columns": [{
            "data": "#",
            "width": "2%"
          },
          {
            "data": "Nombre"
          },
          {
            "data": "Encargado"
          },
          {
            "data": "Usuarios"
          },
          {
            "data": "Editar",
            "width": "5%"
          },
          {
            "data": "Eliminar",
            "width": "5%"
          }
        ]
      });
    }

    function editar_tb(id) {
      $.ajax({
        url: 'consulta_datos_tb.php',
        data: {
          'id': id
        },
        type: "POST",
        success: function(respuesta) {
          $('#editar').show();
          $('#insertar').hide();
          var array = eval(respuesta);
          $('#id_registrotb').val(id);
          $('#nombretb').val(array[0]);
          cargar_tabla_encargados();
          cargar_tabla_usuarios();
          // if(array[1] == 1){
          //   if($('.tipo').hasClass('btn-danger')){
          //   }else{
          //     $('.tipo').removeClass('btn-success');
          //     $('.tipo').addClass('btn-danger');
          //     $('.tipo').html('Perfil');
          //     $('#divtb2').hide();
          //     $('#divtb').show();
          //     $('#tipotb').val("1");
          //   }
          // }else{
          //   if($('.tipo').hasClass('btn-danger')){
          //     $('.tipo').removeClass('btn-danger');
          //     $('.tipo').addClass('btn-success');
          //     $('.tipo').html('Usuario');
          //     $('#divtb').hide();
          //     $('#divtb2').show();
          //     $('#tipotb').val("2");
          //   }else{

          //   }
          // }
        }
      });
    }

    function cargar_tabla_encargados() {
      var id_bodega = $('#id_registrotb').val();
      $('#lista_tipos_encargados').dataTable().fnDestroy();
      $('#lista_tipos_encargados').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "searching": false,
        "paging": false,
        "ajax": {
          "type": "POST",
          "url": "tabla_encargados.php",
          "dataSrc": "",
          "data": {
            'id_bodega': id_bodega
          }
        },
        "columns": [{
            "data": "#",
            "width": "2%"
          },
          {
            "data": "Nombre"
          },
          {
            "data": "Eliminar",
            "width": "5%"
          }
        ]
      });
    }

    function cargar_tabla_usuarios() {
      var id_bodega = $('#id_registrotb').val();
      $('#lista_tipos_usuarios').dataTable().fnDestroy();
      $('#lista_tipos_usuarios').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "searching": false,
        "paging": false,
        "ajax": {
          "type": "POST",
          "url": "tabla_usuarios.php",
          "dataSrc": "",
          "data": {
            'id_bodega': id_bodega
          }
        },
        "columns": [{
            "data": "#",
            "width": "2%"
          },
          {
            "data": "Nombre"
          },
          {
            "data": "Eliminar",
            "width": "5%"
          }
        ]
      });
    }

    function limpiar(id) {
      $('#encargadotb option').each(function(index, option) {
        $(option).remove();
      });
    }

    function eliminar_tb(id) {
      swal({
          title: "¿Está seguro de eliminar registro?",
          icon: "warning",
          buttons: ["No", "Si"],
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            $.ajax({
              url: 'eliminar_tb.php',
              data: {
                'id': id
              },
              type: "POST",
              success: function(respuesta) {
                if (respuesta = "ok") {
                  alertify.success("Registro Eliminado Correctamente");
                  cargar_tabla_tb();
                } else {
                  alertify.error("Ha Ocurrido un Error");
                }
              }
            });
          }
        });
    }

    function eliminar_encargado_tb(id) {
      swal({
          title: "¿Está seguro de eliminar registro?",
          icon: "warning",
          buttons: ["No", "Si"],
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            $.ajax({
              url: 'eliminar_encargado_tb.php',
              data: {
                'id': id
              },
              type: "POST",
              success: function(respuesta) {
                if (respuesta = "ok") {
                  alertify.success("Registro Eliminado Correctamente");
                  cargar_tabla_encargados();
                } else {
                  alertify.error("Ha Ocurrido un Error");
                }
              }
            });
          }
        });
    }

    function eliminar_usuarios_tb(id) {
      swal({
          title: "¿Está seguro de eliminar registro?",
          icon: "warning",
          buttons: ["No", "Si"],
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            $.ajax({
              url: 'eliminar_usuario_tb.php',
              data: {
                'id': id
              },
              type: "POST",
              success: function(respuesta) {
                if (respuesta = "ok") {
                  alertify.success("Registro Eliminado Correctamente");
                  cargar_tabla_usuarios();
                } else {
                  alertify.error("Ha Ocurrido un Error");
                }
              }
            });
          }
        });
    }
  </script>
</body>

</html>