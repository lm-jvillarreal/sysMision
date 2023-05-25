<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set('America/Monterrey');
$fecha = date("Y-m-d");
$hora = date("h:i:s");
?>
<!DOCTYPE html>
<html>

<head>
  <?php include '../head.php'; ?>
</head>

<body class="hold-transition skin-red sidebar-mini" onload="javascript:mostrar_tabla_historial()">
  <div class="wrapper">
    <header class="main-header">
      <?php include '../header.php'; ?>
    </header>
    <aside class="main-sidebar">
      <?php include 'menuV.php'; ?>
    </aside>
    <div class="content-wrapper">
      <section class="content">
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Sistemas | Historial COPIA</h3>
          </div>
          <div class="box-body">
            <form method="POST" id="frmDatosAjustes">
              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                  <div class="form-group">
                    <label>*Sucursal</label>
                    <select name="sucursal" class="form-control" id="suc">
                      <option value="" disabled selected>Seleccione...</option>
                      <option value="1">Diaz Ordaz</option>
                      <option value="2">Arboledas</option>
                      <option value="3">Villegas</option>
                      <option value="4">Allende</option>
                      <option value="5">La Petaca</option>
                      <option value="6">Montemorelos</option>
                      <option value="99">CEDIS</option>
                    </select>
                  </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                  <label>Fecha Inicial</label>
                  <input type="date" id="fecha_inicial" class="form-control" name="fecha_inicial">
                </div>
                <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                  <label>Fecha Final</label>
                  <input type="date" class="form-control" id="fecha_final" name="fecha_final">
                </div>
              </div>
              <div class="row">

              </div>
            </form>
          </div>
          <div class="box box-footer text-right">
            <a href="#" onclick="javascript:mostrar_tabla_historial_fechas()" class="btn btn-danger">Historial</a>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Información</h3>
          </div>
          <div class="box-body" id="div_historial" style="display: none">
            <div class="table-responsive">
              <table id="lista_gastos" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th>Folio</th>
                    <th>Sucursal</th>
                    <th>Movimiento</th>
                    <th>Tipo</th>
                    <th>Factura</th>
                    <th>Proveedor</th>
                    <th>Realizó</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>

                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
          <div class="box-body">
            <div id="contenedor_tabla"></div>
          </div>

        </div>
      </section>
    </div>
    <?php include '../footer2.php'; ?>
    <div class="control-sidebar-bg"></div>
  </div>
  <?php include 'modal.php'; ?>
  <?php include '../footer.php';
  include 'modal_carta.php';
  include 'modal_opciones.php';
  include 'modal_entrada.php';
  ?>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
  <script src="https://code.highcharts.com/highcharts.js"></script>


  <!-- <script>CargarBodega();</script>
<script>CargarSistema();</script> -->
  <script>
    function estilo_tablas() {
      $('#lista').DataTable({
        'paging': false,
        'lengthChange': true,
        'searching': true,
        'ordering': true,
        'info': true,
        'autoWidth': true,
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        }
      })
    }
    $.validator.setDefaults({
      submitHandler: function() {
        var url = "insertar.php";
        $.ajax({
          type: "POST",
          url: url,
          data: $("#form_materiales").serialize(),
          success: function(respuesta) {
            if (respuesta == 1) {
              alertify.error("Algunos Campos Estan Vacios.", 2);
              document.getElementById("nombre").focus();
            } else if (respuesta == 2) {
              alertify.success("Se Regitro Correctamente.", 2);
              $(":text").val('');
              document.getElementById("existencia").value = "";
              // cargar_tabla();
              // CargarBodega();
              // CargarSistema();
              document.getElementById("nombre").focus();
            } else {
              alertify.error("Algo salio Mal.", 2);
              $(":text").val('');
              // cargar_tabla();
            }
          }
        });
        return false;
      }
    });
    $(document).ready(function() {
      $("#form_materiales").validate({
        rules: {
          nombre: "required",
          descripcion: "required",
          bodega: "required",
          existencia: "required"
        },
        messages: {
          nombre: "Campo requerido",
          descripcion: "Campo requerido",
          bodega: "Campo requerido",
          existencia: "Campo requerido"
        },
        errorElement: "em",
        errorPlacement: function(error, element) {
          error.addClass("help-block");
          if (element.prop("type") === "checkbox") {
            error.insertAfter(element.parent("label"));
          } else {
            error.insertAfter(element);
          }
        },
        highlight: function(element, errorClass, validClass) {
          $(element).parents(".col-md-2").addClass("has-error").removeClass("has-success");
          $(element).parents(".col-md-4").addClass("has-error").removeClass("has-success");
          $(element).parents(".col-md-6").addClass("has-error").removeClass("has-success");
          $(element).parents(".col-md-8").addClass("has-error").removeClass("has-success");
          $(element).parents(".col-md-10").addClass("has-error").removeClass("has-success");
          $(element).parents(".col-md-12").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function(element, errorClass, validClass) {
          $(element).parents(".col-md-2").addClass("has-success").removeClass("has-error");
          $(element).parents(".col-md-4").addClass("has-success").removeClass("has-error");
          $(element).parents(".col-md-6").addClass("has-success").removeClass("has-error");
          $(element).parents(".col-md-8").addClass("has-success").removeClass("has-error");
          $(element).parents(".col-md-10").addClass("has-success").removeClass("has-error");
          $(element).parents(".col-md-12").addClass("has-success").removeClass("has-error");
        }
      });
    });
  </script>
  <!-- <script>
    $(function(){
      $('.select2').select2({
        placeholder:"Seleccione una opcion"
      });
    });
</script> -->
  <script type="text/javascript">
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



  <script type="text/javascript">
    function cons() {
      var folio = $('#folio_mov').val();
      var movimiento = $('#movimiento').val();
      var sucursal = $('#suc').val();
      $.ajax({
        url: "consulta_entrada_existe.php",
        type: "POST",
        dateType: "html",
        data: {
          'folio': folio,
          'movimiento': movimiento,
          'sucursal': sucursal
        },
        success: function(respuesta) {
          if (respuesta == "true") {
            consultar();
          } else {
            alert("Ya existe un registro con esos datos");
          }
        },
        error: function(xhr, status) {
          alert(xhr);
        },
      });
    }

    function consultar() {
      $.ajax({
        url: "consulta_entrada.php",
        type: "POST",
        dateType: "html",
        data: $('#frmDatosAjustes').serialize(),
        success: function(respuesta) {
          consultar_detalle();
          var array = eval(respuesta);
          if (array[5] == null) {
            var factura = array[6];
          } else {
            var factura = array[5];
          }
          $('#folio').val(array[0]);
          $('#sucursal').val(array[7]);
          $('#proveedor').val(array[3]);
          $('#tipo_mov').val(array[1]);
          $('#factura').val(factura);
          $('#modal_datos').modal('show');
        },
        error: function(xhr, status) {
          alert(xhr);
        },
      });
    }

    function consultar_detalle() {
      $.ajax({
        url: "consulta_detalle_entrada.php",
        type: "POST",
        dateType: "html",
        data: $('#frmDatosAjustes').serialize(),
        success: function(respuesta) {
          var array_detalle = eval(respuesta);
          $('#ieps').val(array_detalle[3]);
          $('#iva').val(array_detalle[2]);
          $('#subtotal').val(array_detalle[1]);
          $('#total_entrada').val(array_detalle[0]);
        },
        error: function(xhr, status) {
          alert(xhr);
        },
      });
    }
  </script>
  <script type="text/javascript">
    function insertar() {
      $.ajax({
        url: "insertar_registro.php",
        type: "POST",
        dateType: "html",
        data: $('#formulario').serialize(),
        success: function(respuesta) {

          var array = eval(respuesta);
          $('#dif').val(array[1]);
          $('#id_nota').val(array[0]);
          $('#id_nota2').val(array[0]);
          mostrar_tabla(array[0]);
          //$('#modal_opciones').modal('show');


          // const swalWithBootstrapButtons = Swal.mixin({
          //   customClass: {
          //     confirmButton: 'btn btn-success',
          //     cancelButton: 'btn btn-danger'
          //   },
          //   buttonsStyling: false,
          // })

          // swalWithBootstrapButtons.fire({
          //   title: 'Tienes una diferencia de $' + array[1] + '!',
          //   text: "Que deseas hacer?",
          //   type: 'warning',
          //   showCancelButton: true,
          //   confirmButtonText: 'Registrar Diferencia!',
          //   cancelButtonText: 'Subir carta faltante!',
          //   reverseButtons: true
          // }).then((result) => {
          //   if (result.value) {

          //     mostrar_tabla(array[0]);
          //   } else if (
          //     // Read more about handling dismissals
          //     result.dismiss === Swal.DismissReason.cancel
          //   ) {
          //     //alert("fun");
          //     $('#modal_carta').modal('show');
          //     //smostrar_tabla_notas();
          //   }
          // })


        },
        error: function(xhr, status) {
          alert(xhr);
        },
      });
    }

    function mostrar_tabla() {
      var folio = $('#folio_mov').val();
      var movimiento = $('#movimiento').val();
      var sucursal = $('#suc').val();
      let data = {
        folio: folio,
        movimiento: movimiento,
        sucursal: sucursal
      };
      var id = $('#folio_mov').val();
      $.ajax({
        url: "tabla_captura_new.php",
        type: "POST",
        dateType: "html",
        data: data,
        success: function(response) {
          $('#contenedor_tabla').html(response);
        },
        error: function(xhr, status) {

        },
      });
    }

    function consulta_proveedor() {
      var folio = $('#folio_mov').val();
      var movimiento = $('#movimiento').val();
      var sucursal = $('#suc').val();
      let data = {
        folio: folio,
        movimiento: movimiento,
        sucursal: sucursal
      };
      $.ajax({
        url: "consulta_proveedor.php",
        type: "POST",
        dateType: "html",
        data: data,
        success: function(response) {
          $('#proveedor').val(response);
          //$('#contenedor_tabla').html(response);
        },
        error: function(xhr, status) {

        },
      });
    }

    function mostrar_tabla_notas(id_sucursal) {
      $.ajax({
        url: "tabla_notas_diferencia.php",
        type: "POST",
        dateType: "html",
        data: {
          'id_sucursal': id_sucursal
        },
        success: function(respuesta) {
          $('#contenedor_tabla').html(respuesta);
        },
        error: function(xhr, status) {
          alert(xhr);
        },
      });
    }

    function editar() {
      $.ajax({
        url: "consulta_id.php",
        type: "POST",
        dateType: "html",
        data: $('#frmDatosAjustes').serialize(),
        success: function(respuesta) {
          //$('#contenedor_tabla').html(respuesta);
          //alert(respuesta);
          mostrar_tabla(respuesta);
        },
        error: function(xhr, status) {
          alert(xhr);
        },
      });
    }


    function calcular(cantidad, diferencia, n) {
      var calculo = parseFloat(cantidad) * parseFloat(diferencia);
      console.log(calculo);
      $('#total_' + n).val(calculo);

    }

    function registrar_tabla() {
      var folio = $('#folio_mov').val();
      var tipo_mov = $('#movimiento').val();
      var sucursal = $('#suc').val();
      var proveedor = $('#proveedor').val();
      var form_data = new FormData(document.forms.namedItem("frmTabla"));
      form_data.append("folio", folio);
      form_data.append("tipo_mov", tipo_mov);
      form_data.append("sucursal", sucursal);
      form_data.append("proveedor", proveedor);
      fetch('registrar.php', {
        method: 'POST',
        body: form_data
      }).then(function(respuesta) {
        console.log(respuesta);
      });
    }

    function guardar(diferencia) {
      var id = $('#id_nota').val();
      var sucursal = $('#suc').val();
      if (diferencia > 0) {
        const swalWithBootstrapButtons = Swal.mixin({
          customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
          },
          buttonsStyling: false,
        })

        swalWithBootstrapButtons.fire({
          title: 'Tienes una diferencia de $' + diferencia + '!',
          text: "Que deseas hacer?",
          type: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Subir carta faltante',
          cancelButtonText: 'Registrar diferencias',
          reverseButtons: true
        }).then((result) => {
          if (result.value) {
            $('#modal_carta').modal('show');
            //mostrar_tabla_notas(sucursal);
          } else if (
            // Read more about handling dismissals
            result.dismiss === Swal.DismissReason.cancel
          ) {

          }
        });


        // swal({
        //     title: 'La diferencia aún no es de 0',
        //     text: "Que deseas hacer?",
        //     type: 'question',
        //     showCancelButton: true,
        //     confirmButtonColor: '#3085d6',
        //     cancelButtonColor: '#d33',
        //     confirmButtonText: 'Subir Carta faltante!',
        //     cancelButtonText: 'Registrar diferencias',
        //     confirmButtonClass: 'btn btn-success',
        //     cancelButtonClass: 'btn btn-danger',
        //     buttonsStyling: true
        // }).then(function() {
        //     mostrar_tabla_notas();
        // }, function(dismiss) {
        //     if (dismiss === 'cancel') {

        //     }
        // })
      } else {
        alert("Cambios guardados");
        //location.href = "pdfEjemplo/index.php?id="+id;
        window.open("pdfEjemplo/index.php?id=" + id);
        //location.reload();
      }
    }
  </script>
  <script type="text/javascript">
    function mostrar_tabla_historial() {
    var id_sucursal = $('#suc').val();
    $.ajax({
      url: "tabla_historial.php",
      type: "POST",
      dataType: "html",
      data: {},
      success: function(respuesta) {
        $('#contenedor_tabla').html(respuesta);

        $('#tabla_historial').DataTable({
          dom: 'Bfrtip',
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
              title: 'Historial',
              exportOptions: {
                columns: ':visible'
              }
            },
            {
              extend: 'pdf',
              text: 'Exportar a PDF',
              className: 'btn btn-default',
              title: 'Historial',
              exportOptions: {
                columns: ':visible'
              }
            },
            {
              extend: 'copy',
              text: 'Copiar registros',
              className: 'btn btn-default',
              copyTitle: 'Copiado al portapapeles',
              copyKeys: 'Presione <i>ctrl</i> o <i>\u2318</i> + <i>C</i> para copiar los datos de la tabla a su portapapeles. <br><br>Para cancelar, haga clic en este mensaje o presione Esc.',
              copySuccess: {
                _: '%d registros copiados',
                1: '1 registro copiado'
              }
            }
          ]
        });
      },
      error: function(xhr, status) {
        alert(xhr);
      },
    });
  }

    function mostrar_tabla_historial_fechas() {
      var id_sucursal = $('#suc').val();
      //alert(id_sucursal);
      var fecha_inicial = $('#fecha_inicial').val();
      var fecha_final = $('#fecha_final').val();
      $.ajax({
        url: "tabla_historial_fecha.php",
        type: "POST",
        dateType: "html",
        data: {
          'fecha_inicial': fecha_inicial,
          'fecha_final': fecha_final,
          'id_sucursal': id_sucursal
        },
        success: function(respuesta) {
          $('#contenedor_tabla').html(respuesta);

        },
        error: function(xhr, status) {
          alert(xhr);
        },
      });
    }
  </script>

  <script type="text/javascript">
    function eliminar_dif(id, sucursal) {
      $.ajax({
        url: "eliminar_dif.php",
        type: "POST",
        dateType: "html",
        data: {
          'id': id
        },
        success: function(respuesta) {
          alert("Registro borrado");
          mostrar_tabla_cartas(respuesta);

        },
        error: function(xhr, status) {
          alert(xhr);
        },
      });
    }
    function eliminar_dato(id){
      $.ajax({
        url: "eliminar_notaCargo.php",
        type: "POST",
        dateType: "html",
        data: {
          'id': id
        },
        success: function(respuesta) {
          alertify.success("Registro eliminado correctamente");
        },
        error: function(xhr, status) {
          alert(xhr);
        },
      });
    }
  </script>

</body>

</html>