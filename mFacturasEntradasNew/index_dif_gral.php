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
  <script src="funciones.js?v=<?php echo (rand()); ?>"></script>
</head>

<body class="hold-transition skin-red sidebar-mini" onload="javascript:cargar_tabla()">
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
            <h3 class="box-title">Compras | Entradas vs Facturas</h3>
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
                      <option value="99">CEDIS</option>
                    </select>
                  </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                  <div class="form-group">
                    <label for="descripcion">*Movimiento</label>
                    <select name="movimiento" class="form-control" id="movimiento">
                      <option disabled selected>Seleccione...</option>
                      <option value="ENTSOC">Entrada sin orden de compra</option>
                      <option value="ENTCOC">Entrada con orden de compra</option>
                    </select>
                  </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                  <div class="form-group">
                    <label for="bodega">*Folio</label>
                    <input class="form-control" type="text" name="folio" id="folio_mov" onkeyup="if(event.keyCode == 13)execute();">
                  </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                  <div class="form-group">
                    <label for="bodega">Proveedor</label>
                    <input type="text" name="proveedor" id="proveedor" class="form-control" readonly>
                  </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                  <div class="form-group">
                    <label for="bodega">Diferencia</label>
                    <input type="text" name="diferencia" id="txtTotal" class="form-control">
                  </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                  <div class="form-group">
                    <label for="bodega">Impuestos</label>
                    <select class="form-control" onchange="javascript:calcular($('#txtTotal').val() ,$(this).val())">
                      <option selected>Seleccione...</option>
                      <option value="1">Excento</option>
                      <option value="1.16">IVA</option>
                      <option value="1.08">IEPS 8</option>
                      <option value="1.06">IEPS 6</option>
                    </select>
                  </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                  <div class="form-group">
                    <label for="bodega">Diferencia c/impuesto</label>
                    <input type="text" name="dif_impuestos" id="txtDifImp" readonly class="form-control">
                  </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                  <div class="form-group">
                    <label for="bodega">Comentarios</label>
                    <input type="text" name="comentarios" id="txtTotal" class="form-control">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="tipo_operacion">*Tipo operacion</label>
                    <select name="tipo_operacion" id="tipo_operacion" class="form-control">
                      <option value=""></option>
                      <option value="CARGO">CARGO</option>
                      <option value="ABONO">ABONO</option>
                    </select>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="box box-footer text-right">
            <a href="#" onclick="registrar_tabla()" class="btn btn-danger">Registrar</a>
            <button onclick="cons()" class="btn btn-danger">Consultar</button>
          </div>
        </div>
        <div class="box box-danger" style="display: none">
          <div class="box-header">
            <h3 class="box-title">Información</h3>
          </div>
          <div class="box-body">
            <form id="frmTabla" name="frmTabla">
              <div id="contenedor_tabla"></div>
            </form>

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


  <!-- <script>CargarBodega();</script>
<script>CargarSistema();</script> -->
  <script>
    function execute() {
      mostrar_tabla();
      consulta_proveedor();
    }

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
  <!--   <script>
    $(function() {
      $('.select2').select2({
        placeholder: "Seleccione una opcion"
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
            mostrar_tabla();
            consulta_proveedor();
            //registrar_tabla();
            //consultar();
          } else {
            alert("Ya existe un registro con esos datos");
            //mostrar_tabla(); 
            //consulta_proveedor();
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


    function calcular(valor, impuesto) {
      var new_value = parseFloat(valor * impuesto);
      $('#txtDifImp').val(new_value);
    }

    function calcular_total() {
      let total = 0;
      $("#capture > tbody > tr").each(function() {

        var t = $(this).find('td').eq(5).html();
        total = parseFloat(total) + parseFloat(t);
        var a = {
          t: parseFloat(t),
          tot: parseFloat(total)
        };
        $('#txtTotal').val(a.tot);
      });
    }

    function validar() {
      var folio = $('#folio_mov').val();
      var tipo_mov = $('#movimiento').val();
      var sucursal = $('#suc').val();
      var proveedor = $('#proveedor').val();
      $.ajax({
        url: "consulta_existe.php",
        type: "POST",
        dateType: "html",
        data: $('#frmDatosAjustes').serialize(),
        success: function(respuesta) {
          //mostrar_tabla(respuesta);
        },
        error: function(xhr, status) {
          alert(xhr);
        },
      });
    }

    function registrar_tabla() {
      var folio = $('#folio_mov').val();
      var movimiento = $('#movimiento').val();
      var sucursal = $('#suc').val();
      $.ajax({
        url: "registrar_global.php",
        type: "POST",
        dateType: "html",
        data: $('#frmDatosAjustes').serialize(),
        success: function(respuesta) {
          //alert("Guardado");
          window.open("nota_cargo_global.php?folio=" + folio + "&tipo_mov=" + movimiento + "&sucursal=" + sucursal);
          location.reload();
          //mostrar_tabla(respuesta);
        },
        error: function(xhr, status) {
          alert(xhr);
        },
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



      } else {
        alert("Cambios guardados");
        //location.href = "pdfEjemplo/index.php?id="+id;
        window.open("pdfEjemplo/index.php?id=" + id);
        //location.reload();
      }
    }
  </script>
  <script type="text/javascript">
    function mostrar_tabla_cartas() {
      var id_sucursal = $('#suc').val();
      $.ajax({
        url: "tabla_cartas.php",
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
  </script>

</body>

</html>